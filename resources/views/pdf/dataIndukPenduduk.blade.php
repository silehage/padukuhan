<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>BUKU INDUK PADUKUHAN RT 05</title>
   <style>
      * {
         font-size: 10px;
      }

      table {
         border-spacing: 0;
      }

      tr th,
      tr td {
         padding: 4px;
      }

      .page-break {
         page-break-after: always;
      }
   </style>
</head>

<body>
   @foreach($data as $row)
   @if( $loop->iteration % 2 == 1)
   <table style="width:100%;" class="{{ $loop->iteration < (count($data) - 1) ? 'page-break' : '' }}">
      @endif
      @if( $loop->iteration % 2 == 0)
      <tr>
          <td colspan="14" align="center" style="height:20px"></td>
      </tr>
      @endif
      <tr>
         <td colspan="14" align="center" style="height:20px">
            <div style="font-size:16px;font-weight:600">BUKU INDUK PENDUDUK (BIP) RT</div>
         </td>
      </tr>

      <tr>
         <th align="left" colspan="3">Nama Kepala Keluarga</th>
         <th align="left" colspan="3">{{ $row->kepala_keluarga }}</th>
      </tr>
      <tr>
         <th align="left" colspan="3">Nomor Kartu Keluarga</th>
         <th align="left" colspan="3">{{ $row->nomor }}</th>
      </tr>
      <tr>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">NO</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Nama Lengkap</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">NIK</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Jenis<br>Kelamin</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Tempat, Tgl Lahir</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Agama</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Warga<br>Negara</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Status<br>Perkawinan</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Pendidikan Terakhir</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Pekerjaan</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Alamat Lengkap</th>
         <th rowspan="2" align="left" style="border:1px solid #ddd;">Hubungan<br>Keluarga</th>
         <th colspan="2" align="center" style="border:1px solid #ddd;">Nama Orang Tua</th>
      </tr>
      <tr>
         <th style="border:1px solid #ddd;">Ayah</th>
         <th style="border:1px solid #ddd;">Ibu</th>
      </tr>
      @foreach($row->items as $item)
      <tr>
         <td align="left" style="border:1px solid #ddd;width:20px">{{ $loop->iteration }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->nama_lengkap }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->nik }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ str_contains(strtolower($item->Jenis_kelamin), 'laki') ? 'L' : 'P' }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->tempat_lahir }}, <br> {{ $item->tanggal_lahir }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->agama }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->kewarganegaraan }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->status_perkawinan }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->pendidikan }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->jenis_pekerjaan }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $row->alamat }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->status_hubungan_keluarga }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->nama_ayah }}</td>
         <td align="left" style="border:1px solid #ddd;">{{ $item->nama_ibu }}</td>
      </tr>
      @endforeach
      @for($i = 0; $i < (4 -$row->items->count()); $i++)
         <tr>
            @for($j = 0; $j < 14; $j++)
               <td align="left" style="border:1px solid #ddd;height:11px;">
               </td>
               @endfor
         </tr>
         @endfor
         @if( $loop->iteration % 2 == 0)
   </table>
   @endif
   @endforeach
</body>

</html>