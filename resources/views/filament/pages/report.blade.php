<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit" class="mt-2">Terapkan Filter</x-filament::button>
    </form>

    <div class="mt-6 space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold">Hasil Transaksi</h2>
            <a href="{{ $this->getPdfUrl() }}" target="_blank"
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">
                Cetak PDF
            </a>
        </div>

        <x-filament::table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->getTransactions() as $transaction)
                    <tr>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date_transaction)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaction->category->is_expense)
                                <span class="text-red-500">Pengeluaran</span>
                            @else
                                <span class="text-green-500">Pemasukan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-filament::table>
    </div>
</x-filament::page>
