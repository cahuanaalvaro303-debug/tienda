<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'event' => [
                'nullable',
                Rule::in(['created', 'updated', 'deleted', 'restored']),
            ],
            'user_id' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $audits = Audit::with('user')
            ->when(
                $filters['event'] ?? null,
                fn ($query, $event) => $query->where('event', $event)
            )
            ->when(
                $filters['user_id'] ?? null,
                fn ($query, $userId) => $query->where('user_id', $userId)
            )
            ->when(
                $filters['from'] ?? null,
                fn ($query, $date) => $query->where(
                    'created_at',
                    '>=',
                    $date . ' 00:00:00'
                )
            )
            ->when(
                $filters['to'] ?? null,
                fn ($query, $date) => $query->where(
                    'created_at',
                    '<=',
                    $date . ' 23:59:59'
                )
            )
            ->latest()
            ->paginate(20);

        return response()->json($audits);
    }

    public function show(Audit $audit)
    {
        $audit->load('user');

        return response()->json($audit);
    }
}