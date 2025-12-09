<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\FolhaPonto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FolhaPontoController extends Controller
{
    public function index(Funcionario $funcionario)
    {
        $folhas = $funcionario->folhasPonto()
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return view('folha-ponto.index', compact('funcionario', 'folhas'));
    }

    public function create(Funcionario $funcionario)
    {
        return view('folha-ponto.create', compact('funcionario'));
    }

    public function store(Request $request, Funcionario $funcionario)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:2100',
        ]);

        // Verificar se já existe folha para este período
        $exists = FolhaPonto::where('funcionario_id', $funcionario->id)
            ->where('mes', $request->mes)
            ->where('ano', $request->ano)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Já existe uma folha de ponto para este período.');
        }

        $folha = FolhaPonto::inicializarFolha($funcionario->id, $request->mes, $request->ano);

        return redirect()->route('folha-ponto.edit', [$funcionario, $folha])
            ->with('success', 'Folha de ponto criada com sucesso!');
    }

    public function edit(Funcionario $funcionario, FolhaPonto $folha)
    {
        return view('folha-ponto.edit', compact('funcionario', 'folha'));
    }

    public function update(Request $request, Funcionario $funcionario, FolhaPonto $folha)
    {
        $registros = $folha->registros;

        foreach ($request->input('registros', []) as $dia => $dados) {
            if (isset($registros[$dia])) {
                $registros[$dia] = array_merge($registros[$dia], $dados);
            }
        }

        $folha->update([
            'registros' => $registros,
            'fechada' => $request->has('fechar'),
        ]);

        return back()->with('success', 'Folha de ponto atualizada com sucesso!');
    }

    public function pdf(Funcionario $funcionario, FolhaPonto $folha)
    {
        $pdf = Pdf::loadView('pdf.folha-ponto', [
            'funcionario' => $funcionario,
            'folha' => $folha,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("folha_ponto_{$funcionario->matricula}_{$folha->mes}_{$folha->ano}.pdf");
    }

    public function destroy(Funcionario $funcionario, FolhaPonto $folha)
    {
        if ($folha->fechada) {
            return back()->with('error', 'Não é possível excluir uma folha de ponto fechada.');
        }

        $folha->delete();

        return redirect()->route('folha-ponto.index', $funcionario)
            ->with('success', 'Folha de ponto excluída com sucesso!');
    }
}
