<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

      .page-break{
         page-break-after: always;
      }
   </style>
</head>

<body>
   @foreach($data as $row)
    @if( $loop->iteration % 2 == 1)
    <table style="width:100%;" class="{{ $loop->iteration < (count($data) - 1) ? 'page-break' : '' }}">
     @endif
   <tbody>

         <tr>
            <td colspan="10" align="center" style="height:20px">
               @if( $loop->iteration % 2 == 1)
               <div style="font-size:16px;font-weight:600">BUKU KAS</div>
               <div style="font-size:16px;font-weight:600">RT 05</div>
               @endif
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
            <td align="left" style="border:1px solid #ddd;">{{ $item->tanggal }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $item->keterangan }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $item->in_out == 'IN' ? $item->jumlah : '' }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $item->in_out == 'OUT' ? $item->jumlah : '' }}</td>
         </tr>
         @endforeach
         @for($i = 0; $i < 2; $i++)
            <tr>
               <td align="left" style="border:1px solid #ddd;height:10px;"></td>
               <td align="left" style="border:1px solid #ddd;height:10px;"></td>
               <td align="left" style="border:1px solid #ddd;height:10px;"></td>
               <td align="left" style="border:1px solid #ddd;height:10px;"></td>
               <td align="left" style="border:1px solid #ddd;height:10px;"></td>
            </tr>
            @endfor
            <tr>
               <th align="left" style="border:1px solid #ddd;height:10px;" colspan="2"></th>
               <th align="left" style="border:1px solid #ddd;height:10px;">Jml Penerimaan/Pengeluaran</th>
               <th align="left" style="border:1px solid #ddd;height:10px;">{{ $row['total_pendapatan'] }}</th>
               <th align="left" style="border:1px solid #ddd;height:10px;">{{ $row['total_pengeluaran'] }}</th>
            </tr>
            <tr>
               <th align="left" style="border:1px solid #ddd;height:10px;" colspan="2"></th>
               <th align="left" style="border:1px solid #ddd;height:10px;">Saldo Kas Akhir Bulan</th>
               <th align="left" style="border:1px solid #ddd;height:10px;">{{ $row['total_pendapatan'] - $row['total_pengeluaran'] }}</th>
               <th align="left" style="border:1px solid #ddd;height:10px;"></th>
      
            </tr>
      </tbody>
       @if( $loop->iteration % 2 == 0)
   </table>
   @endif
   @endforeach
</body>

</html>