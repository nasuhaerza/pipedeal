@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
        <div>
            <h1 class="h3 mb-1">Pipeline Kanban</h1>
            <p class="text-muted mb-0">Seret deal antar stage untuk memperbarui pipeline secara instan.</p>
        </div>
        <a href="{{ route('dashboard.deals.create') }}" class="btn btn-primary">New Deal</a>
    </div>

    <div class="row gx-3 gy-3">
        @foreach ($stages as $stage)
            <div class="col-12 col-lg-2">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">{{ $stage->stage_name }}</h5>
                            <small class="text-muted">{{ ($dealsByStage[$stage->id] ?? collect())->count() }} deals</small>
                        </div>
                    </div>
                    <div class="card-body px-2 py-3 bg-light pipeline-stage-list" data-stage-id="{{ $stage->id }}">
                        @forelse($dealsByStage[$stage->id] ?? [] as $deal)
                            <div class="card mb-3 border-secondary pipeline-deal-card" data-deal-id="{{ $deal->id }}">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-2">{{ $deal->deal_name }}</h6>
                                    <p class="card-text mb-2 text-muted">{{ $deal->client->name }}</p>
                                    <p class="card-text mb-1 small">Rp {{ number_format($deal->deal_value, 0, ',', '.') }}</p>
                                    <a href="{{ route('dashboard.deals.show', $deal) }}" class="stretched-link text-decoration-none"></a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted small py-4">No deals</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .pipeline-stage-list {
            min-height: 320px;
            max-height: 78vh;
            overflow-y: auto;
        }

        .pipeline-deal-card {
            cursor: grab;
        }

        .pipeline-deal-card.dragging {
            opacity: 0.7;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        const pipelineLists = document.querySelectorAll('.pipeline-stage-list');
        const updateUrlBase = '{{ url('dashboard/pipeline/deals') }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        pipelineLists.forEach(list => {
            new Sortable(list, {
                group: 'pipeline-deals',
                animation: 200,
                ghostClass: 'bg-secondary bg-opacity-10',
                dragClass: 'dragging',
                onAdd: async event => {
                    const dealId = event.item.dataset.dealId;
                    const stageId = event.to.dataset.stageId;

                    try {
                        const response = await fetch(`${updateUrlBase}/${dealId}/stage`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ stage_id: stageId }),
                        });

                        if (!response.ok) {
                            throw new Error('Unable to update deal stage.');
                        }
                    } catch (error) {
                        console.error(error);
                        window.location.reload();
                    }
                },
            });
        });
    </script>
@endpush
