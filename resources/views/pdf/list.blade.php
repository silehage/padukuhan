<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>BUKU INDUK PADUKUHAN RT 05</title>
   <style>
      * {
         font-size: 11px;
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
      <tr>
         <td colspan="12" align="center" style="height:20px">
            @if( $loop->iteration % 2 == 1)
            <div style="font-size:16px;font-weight:600">BUKU INDUK PADUKUHAN RT 05</div>
            @endif
         </td>
      </tr>

      <tr>
         <th align="left" colspan="2">NOMOR</th>
         <th align="left">{{ $row->nomor }}</th>
      </tr>
      <tr>
         <th align="left" colspan="2">KEPALA KELUARGA</th>
         <th align="left">{{ $row->kepala_keluarga }}</th>
      </tr>
      <tr>
         <th align="left" style="border:1px solid #ddd;">NO</th>
         <th align="left" style="border:1px solid #ddd;">NAMA LENGKAP</th>
         <th align="left" style="border:1px solid #ddd;">NIK</th>
         <th align="left" style="border:1px solid #ddd;">JENIS<br>KELAMIN</th>
         <th align="left" style="border:1px solid #ddd;">TEMPAT, TGL LAHIR</th>
         <th align="left" style="border:1px solid #ddd;">AGAMA</th>
         <th align="left" style="border:1px solid #ddd;">KEWARGA<br>NEGARAAN</th>
         <th align="left" style="border:1px solid #ddd;">STATUS<br>PERKAWINAN</th>
         <th align="left" style="border:1px solid #ddd;">PENDIDIKAN TERAKHIR</th>
         <th align="left" style="border:1px solid #ddd;">JENIS PEKERJAAN</th>
         <th align="left" style="border:1px solid #ddd;">ALAMAT LENGKAP</th>
         <th align="left" style="border:1px solid #ddd;">HUBUNGAN<br>KELUARGA</th>
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
      </tr>
      @endforeach
      @for($i = 0; $i < (4 -$row->items->count()); $i++)
         <tr>
            @for($j = 0; $j < 12; $j++)
            <td align="left" style="border:1px solid #ddd;height:11px;"></td>
            @endfor
         </tr>
         @endfor
         @if( $loop->iteration % 2 == 0)
   </table>
   @endif
   @endforeach
</body>

</html>