<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>KAS RT 05</title>
   <style>
      * {
         box-sizing: border-box;
         /* padding: 0; */
      }
      
      body {
         font-size: 12pt;
         margin: 0px;
         padding: 0px;
      }


      @page {
         /* size: 21cm 33cm landscape; */
      }


      table {
         width: 100%;
         border-spacing: 0;
      }

      th.header {
         padding: 2px;
         line-height: normal;
         font-size: 11pt;
      }

      tr th,
      tr td {
         padding: 4px;
      }

      tr td {
         font-size: 11pt;
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

   @foreach($data as $items)
   <table style="width:100%;" class="{{ $loop->iteration < count($data) ? 'page-break' : '' }}">
      <tbody>
         <tr>
            <td colspan="10" align="center" style="height:20px">
               <div style="font-size:16pt;font-weight:600">DAFTAR ANGGOTA DAN PENGURUS</div>
               <div style="font-size:16pt;font-weight:600">RT 05</div>
            </td>
         </tr>

         <tr>
            <th class="header" align="left" colspan="2">DUSUN</th>
            <th class="header" align="left" colspan="2">: KERJO II</th>
         </tr>
         <tr>
            <th class="header" align="left" colspan="2">KELURAHAN</th>
            <th class="header" align="left" colspan="2">: GENJAHAN</th>
            <th class="header" align="left" colspan="2"></th>
            <th class="header" align="left" colspan="2">KAPANEWON</th>
            <th class="header" align="left" colspan="2">: PONJONG</th>
         </tr>
         <tr>
            <th class="header" align="left" colspan="2">KABUPATEN</th>
            <th class="header" align="left" colspan="2">: GUNUNGKIDUL</th>
            <th class="header" align="left" colspan="2"></th>
            <th class="header" align="left" colspan="2">PROPINSI</th>
            <th class="header" align="left" colspan="2">: DAERAH ISTIMEWA YOGYAKARTA</th>
         </tr>
         <tr>
            <th colspan="10"></th>
         </tr>
         <tr>
            <th align="left" style="border:1px solid #ddd;">#</th>
            <th align="left" style="border:1px solid #ddd;">Nama</th>
            <th align="left" style="border:1px solid #ddd;">Jabatan</th>
            <th align="left" style="border:1px solid #ddd;">Jenis Kelamin</th>
            <th align="left" style="border:1px solid #ddd;">Tempat Lahir</th>
            <th align="left" style="border:1px solid #ddd;">Tanggal Lahir</th>
            <th align="left" style="border:1px solid #ddd;">Status</th>
            <th align="left" style="border:1px solid #ddd;">Alamat</th>
            <th align="left" style="border:1px solid #ddd;">Pendidikan</th>
            <th align="left" style="border:1px solid #ddd;">Pekerjaan</th>
         </tr>
         @foreach($items as $row)
         <tr>
            <td align="left" style="border:1px solid #ddd;">{{ $loop->iteration }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $row->nama_lengkap }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $row->jabatan }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $row->Jenis_kelamin == 'PEREMPUAN' ? 'P' : 'L' }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ ucwords(strtolower($row->tempat_lahir)) }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $row->status_perkawinan }}</td>
            <td align="left" style="border:1px solid #ddd;white-space: nowrap;">{{ $row->alamat }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ $row->pendidikan }}</td>
            <td align="left" style="border:1px solid #ddd;">{{ ucwords(strtolower($row->jenis_pekerjaan)) }}</td>
         </tr>

         @endforeach

      </tbody>
   </table>
      @endforeach

</body>

</html>