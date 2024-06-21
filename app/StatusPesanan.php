<?php

namespace App;

enum StatusPesanan: string
{
    case dijemput = 'Sedang Dijemput';
    case sampaiToko = 'Sudah Sampai Toko';
    case diproses = 'Sedang Diproses';
    case packing = 'Sudah Di-packing';
    case kirimKeRumah = 'Sedang Dikirim ke Rumah';
    case selesai = 'Selesai';
    case batal = 'Batal';
}
