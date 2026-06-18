<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Services\ActivityLogService;
use App\Services\DocumentUploadService;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    public function index(): JsonResponse
    {
        $documents = Document::with('deal')->get();

        return response()->json($documents);
    }

    public function store(DocumentRequest $request, DocumentUploadService $uploadService, ActivityLogService $activityLogService): JsonResponse
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
        $activityLogService->record($document, 'created', "Document {$document->name} attached to deal {$document->deal_id}", auth()->user());

        return response()->json($document, 201);
    }

    public function show(Document $document): JsonResponse
    {
        $this->authorize('view', $document);

        return response()->json($document);
    }

    public function update(DocumentRequest $request, Document $document, DocumentUploadService $uploadService, ActivityLogService $activityLogService): JsonResponse
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

        return response()->json($document);
    }

    public function destroy(Document $document): JsonResponse
    {
        $this->authorize('delete', $document);

        $document->delete();

        return response()->json(['message' => 'Document removed.']);
    }
}
