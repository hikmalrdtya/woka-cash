/* ===================================================
   CHAT BUBBLE & TEXT MESSAGE
=================================================== */

function addBubble(text, sender = "user") {
    const chatBox = document.getElementById("chatBox");
    chatBox.innerHTML += `
        <div class="${sender === 'user' ? 'text-right' : 'text-left'}">
            <div class="inline-block ${sender === 'user' ? 'bg-brand-500 text-white' : 'text-black bg-white dark:text-white dark:bg-gray-800'} 
                px-4 py-2 mt-2 rounded-2xl">
                ${text}
            </div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;
}

async function sendMessage(forcedText = null) {
    const input = document.getElementById("input");
    const message = forcedText || input.value.trim();
    const chatBox = document.getElementById("chatBox");

    if (!message) return;

    addBubble(message, "user");
    input.value = "";

    // Loading bubble
    const loadingId = "loading-" + Date.now();
    chatBox.innerHTML += `
        <div id="${loadingId}" class="flex items-center gap-2 text-gray-500">
            <div class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full animate-bounce delay-150"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full animate-bounce delay-300"></div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;

    const res = await fetch("/api/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message })
    });

    const data = await res.json();
    document.getElementById(loadingId)?.remove();

    const reply = data?.choices?.[0]?.message?.content || "AI tidak merespons.";
    addBubble(reply, "ai");
}



/* ===================================================
   VOICE RECORDING + WHISPER STT
=================================================== */

let mediaRecorder;
let audioChunks = [];
let isRecording = false;

const micButton = document.getElementById("micButton");

micButton.addEventListener("click", async () => {

    if (!isRecording) {
        // Start recording
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];

        mediaRecorder.ondataavailable = e => audioChunks.push(e.data);

        mediaRecorder.onstop = async () => {
            const blob = new Blob(audioChunks, { type: "audio/webm" });
            const form = new FormData();
            form.append("audio", blob);

            const res = await fetch("/api/voice-to-text", {
                method: "POST",
                body: form
            });

            const data = await res.json();
            const text = data?.text || "(suara tidak terbaca)";
            sendMessage(text);
        };

        mediaRecorder.start();
        micButton.innerText = "🎙️ Rekam...";
        micButton.classList.add("bg-red-800");

        isRecording = true;

    } else {
        // Stop recording
        mediaRecorder.stop();
        micButton.innerText = "🎤";
        micButton.classList.remove("bg-red-800");
        isRecording = false;
    }
});
