<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>KAS RT 05</title>
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
  
   <div>


      <table style="width:100%;">
         <tbody>

            <tr>
               <td colspan="10" align="center" style="height:20px">
                  <div style="font-size:16px;font-weight:600">BUKU INVENTARIS BARANG</div>
                  <div style="font-size:16px;font-weight:600">RT 05</div>
               </td>
            </tr>

            <tr>
               <th align="left" style="border:1px solid #ddd;">NO</th>
               <th align="left" style="border:1px solid #ddd;">Nama Barang</th>
               <th align="left" style="border:1px solid #ddd;">Asal BArang</th>
               <th align="left" style="border:1px solid #ddd;">Tanggal</th>
               <th align="left" style="border:1px solid #ddd;">Jumlah</th>
               <th align="left" style="border:1px solid #ddd;">Penyimpanan</th>
               <th align="left" style="border:1px solid #ddd;">Kondisi</th>
               <th align="left" style="border:1px solid #ddd;">Ket</th>
            </tr>
             @foreach($data as $row)
            <tr>
               <td align="left" style="border:1px solid #ddd;">{{ $loop->iteration }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->nama_barang }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->asal_barang }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->jumlah }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->tempat_penyimpanan }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->kondisi_barang }}</td>
               <td align="left" style="border:1px solid #ddd;">{{ $row->keterangan }}</td>
            </tr>
               @endforeach
            
         </tbody>
         <tfoot>
               <tr>
                  <td colspan="5"></td>
                 <td colspan="3">
                     <div class="text-footer" style="padding-top:2rem">
                        <div>......................,   ....................................................</div>
                        <div style="padding-top:7px;">Mengetahui</div>
                        <div style="padding-top:7px;">Ketua</div>
                     </div>
                  </td>
               </tr>
               <tr>
                   <td colspan="5"></td>
                  <td colspan="3">
                     <div class="text-footer" style="padding-top:6rem">
                        <div>( .......................................................... )</div>
                     </div>
                  </td>
               </tr>
         </tfoot>
      </table>
   </div>

</body>

</html>