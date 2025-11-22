<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Relatório de Vacinas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 10px;
            font-size: 13px;
            color: #333;
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #0047AB;
            padding-bottom: 14px;
            margin-bottom: 28px;
        }

        .header img {
            width: 160px;
            margin-left: 270px;
            border-radius: 6px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: #0047AB;
            letter-spacing: 0.5px;
        }

        /* Card de informações */
        .info {
            background: #f3f6fa;
            padding: 18px 22px;
            border-radius: 6px;
            border-left: 4px solid #0047AB;
            margin-bottom: 30px;
        }

        .info p {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }

        th {
            background: #e2e8f0;
            font-weight: bold;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #0047AB;
            color: #0047AB;
            letter-spacing: 0.3px;
        }

        td {
            padding: 11px 10px;
            border-bottom: 1px solid #cbd5e1;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .status-col {
            text-align: center;
            width: 140px;
        }

        /* Badges */
        .status-badge {
            display: inline-block;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-aplicada {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }

        .status-a-tomar {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        .status-aguardando-aplicacao {
            background: #dbeafe;
            color: #0047AB;
            border: 1px solid #93c5fd;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('img/logo_02.jpeg') }}" alt="Logo">
        <div class="header-title">Relatório de Vacinas</div>
    </div>

    <div class="info">
        <p><strong>Usuário:</strong> {{ $user->name }}</p>
        <p><strong>Data do relatório:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        <p><strong>Gerado pelo sistema:</strong> e-Vacina</p>
        <p><strong>Total de vacinas:</strong> {{ $vaccineCount}}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Vacina</th>
                <th>Faixa etária</th>
                <th>Data da aplicação</th>
                <th class="status-col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vaccines as $vaccine)
            <tr>
                <td>{{ $vaccine->name }}</td>
                <td>{{ $vaccine->age_range }}</td>
                <td>{{ \Carbon\Carbon::parse($vaccine->application_date)->format('d/m/Y') }}</td>
                <td class="status-col">

                    @php
                    $statusClass = [
                    'Aplicada' => 'status-aplicada',
                    'A Tomar' => 'status-a-tomar',
                    'Aguardando Aplicação' => 'status-aguardando-aplicacao'
                    ][$vaccine->status] ?? '';
                    @endphp

                    <span class="status-badge {{ $statusClass }}">
                        {{ $vaccine->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>