<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>KAS RT 05</title>
   <style>
      * {
         font-size: 12pt;
         box-sizing: border-box;
         padding: 0;
         margin: 0;
      }

       /* @page { size: 21cm 33cm portrait } */

      body {
         width: 100%;
         margin: 0;
         padding: 5px;
      }

      table {
         width: 100%;
         border-spacing: 0;
      }

      tr th,
      tr td {
         padding: 4px;
      }

      .page-break {
         page-break-after: always;
      }

      .text-center {
         text-align: center;
      }

      .text-footer {
         text-align: center;
         font-size: 16px;
         font-weight: 600;
      }
   </style>
</head>

<body>
   @foreach($data as $row)
   <div class="{{ $loop->last ? '' : 'page-break' }}" style="width: 100%;">


      <table style="width:100%;">
         <tbody>

            <tr>
               <td colspan="10" align="center" style="height:20px">
                  <div style="font-size:16px;font-weight:600">BUKU KAS</div>
                  <div style="font-size:16px;font-weight:600">RT 05</div>
               </td>
            </tr>

            <tr>
               <th align="left">Bulan</th>
               <th align="left">{{ $row['label'] }}</th>
            </tr>
            <tr>
               <th align="left" style="border:1px solid #ddd;">NO</th>
               <th align="left" style="border:1px solid #ddd;">Tanggal</th>
               <th align="left" style="border:1px solid #ddd;">Uraian</th>
               <th align="left" style="border:1px solid #ddd;">Penerimaan</th>
               <th align="left" style="border:1px solid #ddd;">Pengeluaran</th>
            </tr>
            @foreach($row['items'] as $item)
            <tr>
               <td align="left" style="border:1px solid #ddd;">{{ $loop->iteration }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $item->keterangan }}</td>
               <td align="right" style="border:1px solid #ddd;">{{ $item->in_out == 'IN' ? $item->jumlah : '' }}</td>
               <td align="right" style="border:1px solid #ddd;">{{ $item->in_out == 'OUT' ? $item->jumlah : '' }}</td>
            </tr>
            @endforeach
            @for($i = 0; $i < (24 - count($row['items'])); $i++)
               <tr>
               @for($j = 0; $j < 5; $j++)
                  <td align="left" style="border:1px solid #ddd;height:10px;">
                  </td>
                  @endfor
                  </tr>
                  @endfor
                  <tr>
                     <th align="left" style="border:1px solid #ddd;height:10px;"></th>
                     <th align="left" style="border:1px solid #ddd;height:10px;"></th>
                     <th align="left" style="border:1px solid #ddd;height:10px;">Jml Penerimaan/Pengeluaran</th>
                     <th align="right" style="border:1px solid #ddd;height:10px;">{{ $row['total_pendapatan'] }}</th>
                     <th align="right" style="border:1px solid #ddd;height:10px;">{{ $row['total_pengeluaran'] }}</th>
                  </tr>
                  <tr>
                     <th align="left" style="border:1px solid #ddd;height:10px;"></th>
                     <th align="left" style="border:1px solid #ddd;height:10px;"></th>
                     <th align="left" style="border:1px solid #ddd;height:10px;">Saldo Akhir</th>
                     <th align="right" style="border:1px solid #ddd;height:10px;" colspan="2">{{ $row['total_pendapatan'] - $row['total_pengeluaran'] }}</th>

                  </tr>
                  <tr>
                     <td colspan="3">
                        <div class="text-footer" style="padding-top:2rem">
                           <div>Menyetujui</div>
                           <div>Ketua</div>
                        </div>
                     </td>
                     <td colspan="2">
                        <div class="text-footer" style="padding-top:2rem">
                           <div>......................, ....................................................</div>
                           <div style="padding-top:7px;">Pemegang Kas</div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3">
                        <div class="text-footer" style="padding-top:6rem">
                           <div>( .......................................................... )</div>
                        </div>
                     </td>
                     <td colspan="2">
                        <div class="text-footer" style="padding-top:6rem">
                           <div>( .......................................................... )</div>
                        </div>
                     </td>
                  </tr>
         </tbody>
      </table>
   </div>
   @endforeach
</body>

</html>