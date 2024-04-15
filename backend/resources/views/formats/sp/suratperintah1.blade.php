<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contoh Surat</title>
  </head>
  <body>
    <center>
      <table width="525">
        <tr>
          <td width="90"><img src="data:image/png;base64,{{ $logo }}" width="90" height="110" /></td>
          <td style="font-family: 'Times New Roman', Times, serif; font-size: 13px">
            <center>
              <font size="4"><b>{{$surat->formattsuratperintah->judul}}</b> </font><br />
              <font size="5"><b>{{$surat->formattsuratperintah->nama_lembaga}}</b></font
              ><br />
              <font size="2"><b>{{$surat->formattsuratperintah->alamat}}</b></font
              ><br />
              <font size="2"><i>Website : {{$surat->formattsuratperintah->website}}</i></font
              ><br />
              <font size="2"><i>{{$surat->formattsuratperintah->kota_pos}}</i></font
                >
            </center>
          </td>
          <td width="50"><br></td>
        </tr>
        <tr>
          <td colspan="3"><hr style="border: 1px solid" /></td>
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
            <td width="35"><br></td>
            <td width="55" style="vertical-align: top;">Dasar</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
                @foreach ($surat->dasar as $index => $item)
                <table>
                    <tr>
                      <td width="15"  valign="top">{{ $index+1 }}. </td>
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
              <td width="35"><br></td>
              <td width="55" style="vertical-align: top;">Kepada</td>
              <td width="10" style="vertical-align: top;">:</td>
              <td>
                  @foreach ($surat->kepada as $index => $item)
                  <table>
                      <tr>
                          <td width="15"  valign="top">{{ $index+1 }}. </td>
                          <td width="175" valign="top">Nama</td>
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
                          <td valign="top">Pangkat/Golongan</td>
                          <td valign="top">:</td>
                          <td>{{ $item->pangkat }}</td>
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
            <td width="35"><br></td>
            <td width="55" style="vertical-align: top;">Untuk</td>
            <td width="10" style="vertical-align: top;">:</td>
            <td>
                @foreach ($surat->tujuan as $index => $item)
                <table>
                    <tr>
                        <td width="15" valign="top">{{ $index+1 }}.</td>
                        <td style="text-align: justify;">{{ $item->untuk }}</td>
                    </tr>
                </table>
                @endforeach
            </td>
        </tr>
    </table>
    <br>
    <table width="525">
      <tr>
          <td width="305"><br></td>
          <td style="vertical-align: top;">Ditetapkan Di {{$surat->formattsuratperintah->ditetapkan_di}}</td>
      </tr>
      <tr>
        <td width="305"><br></td>
        <td>Pada Tanggal {{ $surat->tanggal }}</td>
      </tr>
  </table>
  <br>
  <table width="525">
      <tr>
          <td width="265"><br></td>
          <td style="vertical-align: top; text-align: center;">a.n {{$surat->formattsuratperintah->atas_nama}},</td>
          <td width="25"><br></td>
      </tr>
  </table>
  <br>
  <br>
  <br>
  <table width="525">
      <tr>
          <td width="265"><br></td>
          <td style="vertical-align: top; text-align: center;">{{$surat->formattsuratperintah->an_nama}}</td>
          <td width="25"><br></td>
      </tr>
      <tr>
          <td width="265"><br></td>
          <td style="vertical-align: top; text-align: center;">{{$surat->formattsuratperintah->an_jabatan}}</td>
          <td width="25"><br></td>
      </tr>
      <tr>
          <td width="265"><br></td>
          <td style="vertical-align: top; text-align: center;">NIP: {{$surat->formattsuratperintah->an_nip}}</td>
          <td width="25"><br></td>
      </tr>
  </table>
    </center>
  </body>
</html>