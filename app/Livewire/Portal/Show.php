<?php

namespace App\Livewire\Portal;

use App\Models\Assunto;
use App\Models\Calendario;
use App\Models\Conselho;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public Conselho $conselho;
    
    public $assunto_id = '';
    public $ano = '';
    public $mes = '';

    public $calendarMonth;
    public $calendarYear;

    public function mount(Conselho $conselho)
    {
        $this->conselho = $conselho->load(['composicoes' => function($query) {
            $query->withTrashed();
        }]);
        $this->calendarMonth = now()->month;
        $this->calendarYear = now()->year;
    }

    public function prevMonth()
    {
        $date = \Carbon\Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        $this->calendarMonth = $date->month;
        $this->calendarYear = $date->year;
    }

    public function nextMonth()
    {
        $date = \Carbon\Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->addMonth();
        $this->calendarMonth = $date->month;
        $this->calendarYear = $date->year;
    }

    #[\Livewire\Attributes\Computed]
    public function calendarDays()
    {
        $startDate = \Carbon\Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Find events in this month
        $eventos = Calendario::with('assunto')
            ->where('id_conselho', $this->conselho->id)
            ->whereBetween(DB::raw('COALESCE(data, DATE(created_at))'), [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        // Group by day
        $eventosPorDia = [];
        foreach ($eventos as $evento) {
            $dia = $evento->data ? $evento->data->day : $evento->created_at->day;
            $eventosPorDia[$dia][] = $evento;
        }

        $days = [];
        // Add empty cells for the first week
        for ($i = 0; $i < $startDate->dayOfWeek; $i++) {
            $days[] = ['empty' => true];
        }

        // Add the days of the month
        for ($day = 1; $day <= $endDate->day; $day++) {
            $days[] = [
                'empty' => false,
                'day' => $day,
                'events' => $eventosPorDia[$day] ?? [],
                'isToday' => now()->isSameDay(\Carbon\Carbon::createFromDate($this->calendarYear, $this->calendarMonth, $day))
            ];
        }

        return $days;
    }

    public function render()
    {
        $assuntos = Assunto::orderBy('descricao')->get();
        
        $query = Calendario::with(['assunto', 'anexos'])
            ->where('id_conselho', $this->conselho->id);

        if ($this->assunto_id) {
            $query->where('id_assunto', $this->assunto_id);
        }

        if ($this->ano) {
            $query->whereRaw('EXTRACT(YEAR FROM COALESCE(data, created_at)) = ?', [$this->ano]); // Fallback safe
        }

        if ($this->mes) {
            $query->whereRaw('EXTRACT(MONTH FROM COALESCE(data, created_at)) = ?', [$this->mes]);
        }

        $calendarios = $query->latest(DB::raw('COALESCE(data, created_at)'))->get();

        // Get available years for the filter (database agnostic)
        $anosDisponiveis = Calendario::where('id_conselho', $this->conselho->id)
            ->get()
            ->map(fn($ev) => $ev->data ? $ev->data->format('Y') : $ev->created_at->format('Y'))
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        return view('livewire.portal.show', compact('assuntos', 'calendarios', 'anosDisponiveis'))
            ->layout('components.layouts.app', ['title' => $this->conselho->nome]);
    }
}
