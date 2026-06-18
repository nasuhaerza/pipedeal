<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Deal;
use App\Models\Document;
use App\Services\ActivityLogService;
use App\Services\DocumentUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentWebController extends Controller
{
    public function index(): View
    {
        $documents = Document::with('deal')->get();

        return view('dashboard.documents.index', compact('documents'));
    }

    public function create(): View
    {
        $deals = Deal::with('client')->orderBy('deal_name')->get();
        $dealId = request()->query('deal_id');

        return view('dashboard.documents.create', compact('deals', 'dealId'));
    }

    public function store(DocumentRequest $request, DocumentUploadService $uploadService, ActivityLogService $activityLogService): RedirectResponse
    {
        $upload = $uploadService->store($request->file('file'), $request->deal_id);

        $document = Document::create([
            'company_id' => auth()->user()->company_id,
            'deal_id' => $request->deal_id,
            'file_name' => $request->file_name,
            'file_path' => $upload['file_path'],
            'uploaded_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        $activityLogService->record($document, 'created', "Document {$document->name} attached to deal {$document->deal->title}", auth()->user());

        return redirect()->route('dashboard.documents.index')->with('status', 'Document saved.');
    }

    public function show(Document $document): View
    {
        $this->authorize('view', $document);

        $document->load('deal.client');

        return view('dashboard.documents.show', compact('document'));
    }

    public function edit(Document $document): View
    {
        $this->authorize('view', $document);

        $deals = Deal::with('client')->orderBy('deal_name')->get();

        return view('dashboard.documents.edit', compact('document', 'deals'));
    }

    public function update(DocumentRequest $request, Document $document, DocumentUploadService $uploadService, ActivityLogService $activityLogService): RedirectResponse
    {
        $this->authorize('update', $document);

        $data = [
            'deal_id' => $request->deal_id,
            'file_name' => $request->file_name,
            'notes' => $request->notes,
        ];

        if ($request->hasFile('file')) {
            $upload = $uploadService->replace($request->file('file'), $request->deal_id, $document->file_path);
            $data['file_path'] = $upload['file_path'];
            $data['uploaded_by'] = auth()->id();
        }

        $document->update($data);
        $activityLogService->record($document, 'updated', "Document {$document->name} updated", auth()->user());

        return redirect()->route('dashboard.documents.index')->with('status', 'Document updated.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        $document->delete();

        return redirect()->route('dashboard.documents.index')->with('status', 'Document removed.');
    }
}
