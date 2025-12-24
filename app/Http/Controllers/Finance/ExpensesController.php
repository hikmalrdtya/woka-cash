<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\OcrResult;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expansesList = Expense::all();

        return view('finance.expenses.index', compact('expansesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects = Project::all();
        $branches = Branch::all();
        return view('finance.expenses.create', compact('projects', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required',
        ]);

        $cleanAmount = str_replace('.', '', $request->amount);

        $expenseData = [];

        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $expenseData['receipt_file'] =
                $file->storeAs('receipts', $fileName, 'public');
        }

        // SIMPAN EXPENSE
        $expense = Expense::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
            'project_id' => $request->project_id,
            'amount' => $cleanAmount,
            'note_number' => $request->note_number,
            'store_name' => $request->store_name,
            'expense_date' => $request->expense_date ?? now()->toDateString(),
            'receipt_file' => $expenseData['receipt_file'] ?? null,
        ]);

        // SIMPAN OCR RESULT
        if ($request->filled('ocr_raw_text')) {
            OcrResult::create([
                'expense_id' => $expense->id,
                'raw_text' => $request->ocr_raw_text,
                'parsed_total' => $cleanAmount,
                'parsed_date' => $request->expense_date,
                'parsed_store' => $request->store_name,
            ]);
        }

        return redirect()
            ->route('finance.expenses.index')
            ->with('success', 'Expense created successfully.');
    }


    public function ocrPreview(Request $request)
    {
        $request->validate([
            'receipt_file' => 'required|file|max:5120',
        ]);

        $path = $request->file('receipt_file')->store('tmp/ocr', 'public');
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            return response()->json([
                'error' => 'File OCR tidak ditemukan'
            ], 500);
        }

        $process = new Process([
            '/usr/bin/tesseract', // PATH ABSOLUT
            $fullPath,
            'stdout',
            '-l',
            'eng+ind'
        ]);

        $process->setTimeout(30);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json([
                'error' => 'OCR gagal dijalankan',
                'detail' => $process->getErrorOutput()
            ], 500);
        }

        $rawText = trim($process->getOutput());

        return response()->json([
            'raw_text' => $rawText,
            'parsed' => $this->parseReceiptText($rawText)
        ]);
    }


    private function parseReceiptText(string $text): array
    {
        // TOTAL
        preg_match('/total\s*[:\-]?\s*rp?\.?\s*([\d\.,]+)/i', $text, $totalMatch);
        $total = $totalMatch[1] ?? null;

        // TANGGAL
        preg_match('/(\d{2}[\/\-]\d{2}[\/\-]\d{4})/', $text, $dateMatch);
        $date = $dateMatch[1] ?? null;

        // NAMA TOKO (ambil baris pertama)
        $lines = array_filter(explode("\n", $text));
        $store = $lines[0] ?? null;

        // NOMOR NOTA
        preg_match('/(no|nota|inv)[\s\:]*([A-Z0-9\-]+)/i', $text, $noteMatch);
        $note = $noteMatch[2] ?? null;

        return [
            'store_name' => $store,
            'note_number' => $note,
            'amount' => $total ? str_replace(['.', ','], ['', '.'], $total) : null,
            'expense_date' => $date
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d')
                : null,
        ];
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if ($expense) {
            $expense->delete();
            return redirect()->back()->with('succes', 'expenses delete succesfully');
        } 
        return redirect()->back()->with('error', 'expense data not found');
    }
}
