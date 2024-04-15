<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contoh Surat</title>
  </head>
  <body>
    <center>
      <table width="525">
        <tr>
          <td style="font-family: 'Times New Roman', Times, serif; font-size: 13px">
            <center>
            <img src="data:image/png;base64,{{ $logo }}" width="90" height="110" />
            <br>
              <font size="4"><b>{{$surat->formattsuratperintah2->judul}}</b> </font><br />
              <font size="5"><b>{{$surat->formattsuratperintah2->nama_lembaga}}</b></font
              ><br />
              <font size="3">{{$surat->formattsuratperintah2->alamat}}</font
              ><br />
              <font size="4"><b>{{$surat->formattsuratperintah2->kota_pos}}</b></font
                ><br />
            </center>
          </td>
        </tr>
        <tr>
          <td><hr style="border: 1px solid" /></td>
        </tr>
      </table>
      <table width="525">
        <tr>
          <td style="font-family: 'Times New Roman', Times, serif; font-size: 18px; text-align: center; font-weight: bold" class="text">
            SURAT PERINTAH
          </td>
        </tr> 
        <tr>
          <td style="text-align: center">Nomor : {{ $surat->no_sp }}/{{ $surat->bidang }}/{{ $surat->dari }}</td>
        </tr>
      </table>
      <table width="525">
        <tr>
            <td width="15"><br></td>
            <td width="115" style="vertical-align: top;">Dasar Pelaksanaan</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
                @foreach ($surat->dasar as $index => $item)
                <table>
                    <tr>
                      <td style="text-align: justify;">
                        {{ $item->kegiatan }}
                      </td>
                    </tr>
                </table>
                @endforeach
            </td>
        </tr>
    </table>
      <table width="525">
        <tr>
          <td style="font-family: 'Times New Roman', Times, serif; font-size: 16px; text-align: center;" class="text">
            MEMERINTAHKAN :
          </td>
        </tr> 
      </table>
        <table width="525">
          <tr>
              <td width="15"><br></td>
              <td width="115" style="vertical-align: top;">Menugaskan Kepada</td>
              <td width="10" style="vertical-align: top;">:</td>
              <td>
                  @foreach ($surat->kepada as $index => $item)
                  <table>
                      <tr>
                          <td width="15"  valign="top">{{ $index+1 }}. </td>
                          <td width="100" valign="top">Nama</td>
                          <td width="10"  valign="top">:</td>
                          <td>{{ $item->name }}</td>
                      </tr>
                      <tr>
                          <td></td>
                          <td valign="top">NIP</td>
                          <td valign="top">:</td>
                          <td>{{ $item->nip }}</td>
                      </tr>
                      <tr>
                          <td></td>
                          <td valign="top">Jabatan</td>
                          <td valign="top">:</td>
                          <td>{{ $item->jabatan }}</td>
                      </tr>
                  </table>
                  @endforeach
              </td>
          </tr>
      </table>
      <table width="525">
        <tr>
            <td width="15"></td>
            <td width="115" style="vertical-align: top;">Untuk</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
                {{$surat->untuk2->untuk}}
            </td>
        </tr>
    </table>
    <table width="525">
        <tr>
            <td width="15"></td>
            <td width="115" style="vertical-align: top;">Lama Perjalanan</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
            {{$surat->untuk2->lamaperjalanan}}
            </td>
        </tr>
    </table>
    <table width="525">
        <tr>
            <td width="15"></td>
            <td width="115" style="vertical-align: top;">Biaya Perjalanan</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
              dibebankan pada Kegiatan: <br>
            {{$surat->untuk2->biayaperjalanan}}
            </td>
        </tr>
    </table>
    <br>
    <table width="525">
        <tr>
            <td width="75"></td>
            <td>
                Demikian Surat Tugas ini dikeluarkan kepada yang bersangkutan untuk dilaksanakan
            </td>
        </tr>
    </table>
    <table width="525">
        <tr>
            <td width="25"></td>
            <td>
            mestinya dengan sepenuh rasa tanggung jawab
            </td>
        </tr>
    </table>
    <table width="525">
      <tr>
        <td width="270"></td>
        <td width="100">Dikeluarkan di</td>
        <td>: Bandung</td>
        <td width="50"></td>
      </tr>
      <tr>
        <td></td>
        <td>Pada tanggal</td>
        <td>: {{$surat->tanggal}}</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><hr style="border: 1px solid" /></td>
        <td></td>
      </tr>
    </table>
    <table width="525">
      <tr>
        <td width="270"></td>
        <td style="text-align: center;">a.n.{{$surat->formattsuratperintah2->atas_nama}} <br> plt.{{$surat->formattsuratperintah2->pelaksanaan_tugas}}</td>
        <td width="50"></td>
      </tr>
    </table>
    <br>
    <br>
    <br>
    <table width="525">
      <tr>
        <td width="290"></td>
        <td colspan="2"><u>{{$surat->FormattSuratPerintah2->an_nama}}</u></td>
        <td width="20"></td>
      </tr>
    </table>
    <table width="525">
      <tr>
        <td width="290"></td>
        <td width="30">Pangkat</td>
        <td>: {{$surat->FormattSuratPerintah2->an_pangkat}}</td>
        <td width="20"></td>
      </tr>
      <tr>
        <td width="290"></td>
        <td width="30">Nip</td>
        <td>: {{$surat->FormattSuratPerintah2->an_nip}}</td>
        <td width="20"></td>
      </tr>
    </table>
    <table width="525">
     <tr>
      <td width="15"></td>
      <td><b>Tembusan</b>:<i> Disampaikan Kepada Yth, ;</i></td>
     </tr>
     @foreach ($surat->disampaikan as $index => $item)
      <tr>
        <td></td>
        <td>{{$index+1}}. {{$item->nama}}</td>
      </tr>
     @endforeach
    </table>
    </center>
  </body>
</html>