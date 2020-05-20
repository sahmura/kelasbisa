<page backtop="-5mm" backbottom="-10mm" backright="-5mm" backleft="-5mm">
    <table cellpadding='0' cellspacing='0'>
        <tr style="position: fixed;">
            <td><img src="assets/sertificate/headerName.png" alt="" style="width: 1121px;"></td>
        </tr>
    </table>
    <table cellpadding='0' cellspacing='0' style="margin-top: 57px; text-align: center;">
        <tr>
            <td style="text-align: center; font-size: 16px; width: 1121px;">Nomor: {{ $data->nomor }}</td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 16px; width: 1121px;">Sertifikat diberikan kepada</td>
        </tr>
        <tr>
            <td
                style="text-align: center; font-size: 36px; width: 1121px;padding: 30px 0px; font-weight: 600; color: #16A4E0;">
                <b>{{ $data->user->name }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 16px; width: 1121px;">Atas partisipasinya dalam kelas online
                dengan judul<br>
                <b style="fonr-size: 22px">{{ $data->class->name }}</b><br>
                yang diselenggarakan oleh Kelasbisa dalam platform Kelasbisa<br>
                pada {{ $data->date }}</td>
        </tr>
    </table>
    <table cellpadding='0' cellspacing='0' style="margin-top: 40px; text-align: center;">
        <tr>
            <td style="text-align: center; font-size: 18px; width: 561px;">Penyelenggara</td>
            <td style="text-align: center; font-size: 18px; width: 561px;">Pembicara</td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 18px; width: 561px; padding: 20px 0px;">
                <img src="assets/sertificate/tanda-tangan-khoerul-umam.png" alt="" style="width: 120px;">
                </td>
            <td style="text-align: center; font-size: 18px; width: 561px;">
                <img src="assets/signature/{{ $data->class->speaker->signature }}" alt="" style="width: 120px;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 18px; width: 561px;"><b>Khoerul Umam</b></td>
            <td style="text-align: center; font-size: 18px; width: 561px;"><b>{{ $data->class->speaker->name }}</b></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 18px; width: 561px;">CEO Kelasbisa</td>
            <td style="text-align: center; font-size: 18px; width: 561px;">{{ $data->class->speaker->skill }}</td>
        </tr>
    </table>
    <table cellpadding='0' cellspacing='0'>
        <tr>
            <td style="padding-top: 14px;position: fixed;"><img src="assets/sertificate/footer.png" alt="" style="width: 1121px;"></td>
        </tr>
    </table>
</page>
