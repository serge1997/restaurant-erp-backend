<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Requisição de Compra #{{ $requisition->code }}</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
      color: #1a1a1a;
      background: #ffffff;
      line-height: 1.4;
    }

    /* ── PAGE ── */
    .page {
      padding: 32px 36px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── HEADER ── */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 24px;
      padding-bottom: 20px;
      border-bottom: 2px solid #0E7C7B;
    }

    .header-brand {}
    .brand-name {
      font-size: 20px;
      font-weight: 700;
      color: #0E7C7B;
      letter-spacing: -0.5px;
    }
    .brand-sub {
      font-size: 10px;
      color: #666;
      margin-top: 2px;
    }

    .header-doc {
      text-align: right;
    }
    .doc-title {
      font-size: 14px;
      font-weight: 700;
      color: #1a1a1a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .doc-code {
      font-size: 13px;
      font-weight: 600;
      color: #0E7C7B;
      font-family: 'Courier New', monospace;
      margin-top: 2px;
    }
    .doc-date {
      font-size: 10px;
      color: #666;
      margin-top: 3px;
    }

    /* ── STATUS BADGE ── */
    .status-row {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 16px;
    }
    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .badge-pending    { background: #FFFBEB; color: #D97706; border: 1px solid #FCD34D; }
    .badge-approved   { background: #ECFDF5; color: #059669; border: 1px solid #6EE7B7; }
    .badge-rejected   { background: #FEF2F2; color: #DC2626; border: 1px solid #FCA5A5; }
    .badge-completed  { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
    .badge-cancelled  { background: #F3F4F6; color: #6B7280; border: 1px solid #D1D5DB; }

    /* ── SECTION ── */
    .section {
      margin-bottom: 20px;
    }
    .section-title {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #0E7C7B;
      margin-bottom: 8px;
      padding-bottom: 4px;
      border-bottom: 1px solid #E0F2F1;
    }

    /* ── INFO GRID ── */
    .info-grid {
      display: table;
      width: 100%;
      border-collapse: collapse;
    }
    .info-grid-row {
      display: table-row;
    }
    .info-grid-row td {
      display: table-cell;
      padding: 5px 8px;
      border: 1px solid #E5E7EB;
      vertical-align: top;
    }
    .info-label {
      font-size: 9px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #6B7280;
      margin-bottom: 2px;
    }
    .info-value {
      font-size: 11px;
      font-weight: 500;
      color: #1a1a1a;
    }
    .info-cell-bg {
      background: #F9FAFB;
    }

    /* two-col and three-col layout via table */
    table.layout {
      width: 100%;
      border-collapse: collapse;
    }
    table.layout td {
      vertical-align: top;
      padding: 0 6px;
    }
    table.layout td:first-child { padding-left: 0; }
    table.layout td:last-child  { padding-right: 0; }

    /* ── PRODUCTS TABLE ── */
    .products-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4px;
    }
    .products-table thead tr {
      background: #0E7C7B;
    }
    .products-table thead th {
      padding: 7px 10px;
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #ffffff;
      text-align: left;
    }
    .products-table thead th.right { text-align: right; }
    .products-table thead th.center { text-align: center; }

    .products-table tbody tr {
      border-bottom: 1px solid #E5E7EB;
    }
    .products-table tbody tr:nth-child(even) {
      background: #F9FAFB;
    }
    .products-table tbody tr:hover {
      background: #EAF5F5;
    }
    .products-table tbody td {
      padding: 7px 10px;
      font-size: 11px;
      color: #374151;
      vertical-align: middle;
    }
    .products-table tbody td.right  { text-align: right; }
    .products-table tbody td.center { text-align: center; }
    .products-table tbody td.mono   { font-family: 'Courier New', monospace; }

    .product-name { font-weight: 600; color: #111827; }
    .product-unit { font-size: 10px; color: #6B7280; margin-top: 1px; }

    .qty-badge {
      display: inline-block;
      background: #EAF5F5;
      color: #0E7C7B;
      border: 1px solid #A8D8D8;
      border-radius: 3px;
      padding: 1px 7px;
      font-size: 11px;
      font-weight: 600;
      font-family: 'Courier New', monospace;
    }

    /* ── OBSERVATION ── */
    .obs-box {
      background: #FFFBEB;
      border: 1px solid #FCD34D;
      border-left: 3px solid #D97706;
      border-radius: 4px;
      padding: 10px 12px;
    }
    .obs-label {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #D97706;
      margin-bottom: 4px;
    }
    .obs-text {
      font-size: 11px;
      color: #374151;
      line-height: 1.6;
    }

    /* ── SUMMARY BOX ── */
    .summary-box {
      border: 1px solid #E5E7EB;
      border-radius: 6px;
      overflow: hidden;
      margin-top: 4px;
    }
    .summary-row {
      display: table;
      width: 100%;
    }
    .summary-row td {
      display: table-cell;
      padding: 6px 12px;
      border-bottom: 1px solid #E5E7EB;
      vertical-align: middle;
    }
    .summary-row:last-child td { border-bottom: none; }
    .summary-row.total td { background: #0E7C7B; }
    .summary-label { font-size: 10px; color: #6B7280; }
    .summary-value { font-size: 11px; font-weight: 600; color: #111827; text-align: right; font-family: 'Courier New', monospace; }
    .summary-row.total .summary-label { color: #ffffff; font-size: 11px; font-weight: 600; }
    .summary-row.total .summary-value { color: #ffffff; font-size: 13px; }

    /* ── SIGNATURES ── */
    .signatures {
      display: table;
      width: 100%;
      margin-top: 32px;
    }
    .signatures td {
      display: table-cell;
      width: 33.33%;
      text-align: center;
      padding: 0 12px;
      vertical-align: bottom;
    }
    .sig-line {
      border-top: 1px solid #374151;
      padding-top: 6px;
      margin-top: 36px;
    }
    .sig-name {
      font-size: 11px;
      font-weight: 600;
      color: #111827;
    }
    .sig-role {
      font-size: 9px;
      color: #6B7280;
      margin-top: 2px;
    }

    /* ── FOOTER ── */
    .footer {
      margin-top: auto;
      padding-top: 16px;
      border-top: 1px solid #E5E7EB;
      display: table;
      width: 100%;
    }
    .footer td {
      display: table-cell;
      vertical-align: middle;
    }
    .footer-left {
      font-size: 9px;
      color: #9CA3AF;
    }
    .footer-right {
      text-align: right;
      font-size: 9px;
      color: #9CA3AF;
    }
    .footer-teal { color: #0E7C7B; font-weight: 600; }

    /* ── PRIORITY BADGE ── */
    .priority-normal  { color: #6B7280; }
    .priority-high    { color: #D97706; font-weight: 600; }
    .priority-urgent  { color: #DC2626; font-weight: 700; }

    /* ── UTILS ── */
    .text-muted { color: #6B7280; }
    .text-center { text-align: center; }
    .mt-4 { margin-top: 16px; }
    .mb-0 { margin-bottom: 0; }
  </style>
</head>
<body>
<div class="page">

  {{-- ── HEADER ── --}}
  <div class="header">
    <div class="header-brand">
      <div class="brand-name">{{ $restaurant->name ?? 'RestoERP' }}</div>
      <div class="brand-sub">{{ $restaurant->address ?? '' }} {{ $restaurant->number ?? '' }}</div>
      @if($restaurant->cnpj ?? null)
        <div class="brand-sub">CNPJ: {{ $restaurant->cnpj }}</div>
      @endif
    </div>
    <div class="header-doc">
      <div class="doc-title">Requisição de Compra</div>
      <div class="doc-code">#{{ $requisition->code }}</div>
      <div class="doc-date">
        Emitido em {{ now()->format('d/m/Y \à\s H:i') }}
      </div>
    </div>
  </div>

  {{-- ── STATUS ── --}}
  <div class="status-row">
    @php
      $statusClasses = [
        'pendente'   => 'badge-pending',
        'aprovado'  => 'badge-approved',
        'rejeitada'  => 'badge-rejected',
        'completo' => 'badge-completed',
        'parcial' => 'badge-cancelled',
      ];
      $statusKey = strtolower($requisition->status->getLabel()) ?? 'pending';
    @endphp
    <span class="badge {{ $statusClasses[$statusKey] ?? 'badge-pending' }}">
      {{ $requisition->status->getLabel() ?? '' }}
    </span>
  </div>

  {{-- ── INFORMAÇÕES GERAIS ── --}}
  <div class="section">
    <div class="section-title">Informações gerais</div>
    <table class="layout">
      <tr>
        <td style="width: 50%">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; background: #F9FAFB; width: 40%">
                <div class="info-label">Solicitante</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none;">
                <div class="info-value">{{ $requisition->createdBy->name ?? '—' }}</div>
              </td>
            </tr>
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-top: none; background: #F9FAFB;">
                <div class="info-label">Departamento</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none; border-top: none;">
                <div class="info-value">{{ $requisition->department->getLabel() ?? 'Todos' }}</div>
              </td>
            </tr>
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-top: none; background: #F9FAFB;">
                <div class="info-label">Prioridade</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none; border-top: none;">
                @php
                  $priorityClasses = [
                    'normal'  => 'priority-normal',
                    'high'    => 'priority-high',
                    'urgent'  => 'priority-urgent',
                  ];
                  $pKey = $requisition->priority->getLabel() ?? 'normal';
                @endphp
                <div class="info-value {{ $priorityClasses[$pKey] ?? 'priority-normal' }}">
                  {{ strtoupper($requisition->priority->getLabel()) ?? 'Normal' }}
                </div>
              </td>
            </tr>
          </table>
        </td>
        <td style="width: 50%">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; background: #F9FAFB; width: 45%">
                <div class="info-label">Data da requisição</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none;">
                <div class="info-value">{{ $requisition->created_at->format('d/m/Y') }}</div>
              </td>
            </tr>
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-top: none; background: #F9FAFB;">
                <div class="info-label">Data de entrega</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none; border-top: none;">
                <div class="info-value">
                  {{ $requisition->delivery_at ? \Carbon\Carbon::parse($requisition->delivery_at)->format('d/m/Y') : '—' }}
                </div>
              </td>
            </tr>
            @if($requisition->approvedBy ?? null)
            <tr>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-top: none; background: #F9FAFB;">
                <div class="info-label">Aprovado por</div>
              </td>
              <td style="padding: 5px 8px; border: 1px solid #E5E7EB; border-left: none; border-top: none;">
                <div class="info-value">{{ $requisition->approvedBy->name }}</div>
              </td>
            </tr>
            @endif
          </table>
        </td>
      </tr>
    </table>
  </div>

  {{-- ── OBSERVAÇÃO ── --}}
  @if($requisition->observation ?? null)
  <div class="section">
    <div class="obs-box">
      <div class="obs-label">Observação</div>
      <div class="obs-text">{{ $requisition->observation }}</div>
    </div>
  </div>
  @endif

  {{-- ── PRODUTOS ── --}}
  <div class="section">
    <div class="section-title">Produtos solicitados</div>
    <table class="products-table">
      <thead>
        <tr>
          <th style="width: 30px">#</th>
          <th>Produto</th>
          <th class="center" style="width: 80px">Unidade</th>
          <th class="center" style="width: 80px">Quantidade</th>
          <th class="center" style="width: 80px">Recebido</th>
          <th class="right" style="width: 100px">Custo unit.</th>
          <th class="right" style="width: 100px">Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse($requisition->items as $index => $item)
          <tr>
            <td class="center text-muted">{{ $index + 1 }}</td>
            <td>
              <div class="product-name">{{ $item->product->name ?? $item->name }}</div>
              @if($item->product->description ?? null)
                <div class="product-unit">{{ Str::limit($item->product->description, 60) }}</div>
              @endif
            </td>
            <td class="center text-muted">
              {{ $item->unit_of_measure ?? '—' }}
            </td>
            <td class="center">
              <span class="qty-badge">{{ number_format($item->ordered_quantity, 0, ',', '.') }}</span>
            </td>
            <td class="center">
              @php
                $quantity = $item->product->unit_contain ?? 1;
              @endphp
              <span class="qty-badge">{{ number_format($item->received_quantity / $quantity, 0, ',', '.') }}</span>
            </td>
            <td class="right mono">
              @if($item->cost ?? null)
                R$ {{ number_format($item->cost, 2, ',', '.') }}
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="right mono">
              @if($item->cost ?? null)
                R$ {{ number_format($item->total_cost, 2, ',', '.') }}
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted" style="padding: 16px;">
              Nenhum produto cadastrado nesta requisição.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ── RESUMO ── --}}
  @php
    $totalItems = $requisition->items->count();
    $totalQty   = $requisition->items->sum('quantity');
    $totalValue = $requisition->items->sum(fn($i) => ($i->unit_price ?? 0) * $i->quantity);
    $hasPrice   = $requisition->items->whereNotNull('unit_price')->count() > 0;
  @endphp

  <div class="section">
    <table class="layout">
      <tr>
        <td style="width: 60%"></td>
        <td style="width: 40%">
          <div class="summary-box">
            <table width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding: 6px 12px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB;">
                  <span class="summary-label">Total de itens</span>
                </td>
                <td style="padding: 6px 12px; border-bottom: 1px solid #E5E7EB; text-align: right;">
                  <span class="summary-value">{{ $totalItems }} produto(s)</span>
                </td>
              </tr>
              <tr>
                <td style="padding: 6px 12px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB;">
                  <span class="summary-label">Quantidade total</span>
                </td>
                <td style="padding: 6px 12px; border-bottom: 1px solid #E5E7EB; text-align: right;">
                  <span class="summary-value">{{ number_format($totalQty, 0, ',', '.') }} un.</span>
                </td>
              </tr>
              @if($hasPrice)
              <tr>
                <td style="padding: 8px 12px; background: #0E7C7B;">
                  <span style="color: #fff; font-size: 11px; font-weight: 600;">Valor estimado</span>
                </td>
                <td style="padding: 8px 12px; background: #0E7C7B; text-align: right;">
                  <span style="color: #fff; font-size: 13px; font-weight: 700; font-family: 'Courier New', monospace;">
                    R$ {{ number_format($totalValue, 2, ',', '.') }}
                  </span>
                </td>
              </tr>
              @endif
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  {{-- ── ASSINATURAS ── --}}
  <table class="signatures">
    <tr>
      <td>
        <div class="sig-line">
          <div class="sig-name">{{ $requisition->createdBy->name ?? '___________________' }}</div>
          <div class="sig-role">Solicitante</div>
        </div>
      </td>
      <td>
        <div class="sig-line">
          <div class="sig-name">___________________</div>
          <div class="sig-role">Responsável pelo setor</div>
        </div>
      </td>
      <td>
        <div class="sig-line">
          <div class="sig-name">{{ $requisition->approvedBy->name ?? '___________________' }}</div>
          <div class="sig-role">Aprovação</div>
        </div>
      </td>
    </tr>
  </table>

  {{-- ── FOOTER ── --}}
  <div class="footer" style="margin-top: 24px; padding-top: 12px; border-top: 1px solid #E5E7EB;">
    <table width="100%">
      <tr>
        <td>
          <span style="font-size: 9px; color: #9CA3AF;">
            Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }} · {{ $restaurant->name ?? 'RestoERP' }}
          </span>
        </td>
        <td style="text-align: right;">
          <span style="font-size: 9px; color: #9CA3AF;">
            Requisição <span style="color: #0E7C7B; font-weight: 600;">#{{ $requisition->code }}</span>
          </span>
        </td>
      </tr>
    </table>
  </div>

</div>
</body>
</html>