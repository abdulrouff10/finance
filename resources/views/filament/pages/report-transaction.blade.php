<x-filament::page>
    <div class="report-page">
        <div class="mb-4">
            {{ $this->form }}
        </div>

       <div style="text-align: right; margin-bottom: 20px;">
    <a href="{{ route('transactions.report.pdf', ['start' => $startDate, 'end' => $endDate]) }}"
       target="_blank"
       style="
           display: inline-block;
           padding: 6px 16px;
           background-color: #f59e0b;          /* amber-500 */
           color: white;
           border: 1px solid #d97706;          /* amber-600 */
           border-radius: 6px;
           font-weight: 600;
           font-size: 14px;
           text-decoration: none;
           box-shadow: 0 1px 2px rgba(0,0,0,0.08);
           transition: background-color 0.2s ease;
       "
       onmouseover="this.style.backgroundColor='#d97706'"
       onmouseout="this.style.backgroundColor='#f59e0b'">
        Cetak PDF
    </a>
</div>

{{-- Tabel Laporan --}}
<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background-color: #f59e0b; color: white;">
                <th style="padding: 8px; border: 1px solid #ddd;">Tanggal</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Nama</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Kategori</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Jumlah</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Tipe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->getTransactions() as $item)
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ \Carbon\Carbon::parse($item->date_transaction)->format('d M Y') }}
                    </td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ $item->name }}
                    </td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ $item->category->name }}
                    </td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        Rp {{ number_format($item->amount, 0, ',', '.') }}
                    </td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ $item->category->is_expense ? 'Pengeluaran' : 'Pemasukan' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
</x-filament::page>
