SELECT b.created_date, b.no_rekening, a.tgl_realisasi, d.nama_nasabah,
a.jml_angsuran, a.kode_asuransi, e.deskripsi_asuransi, b.rate, b.nilai_pertanggungan,
b.titipan_asuransi, c.alamat_sertifikat, c.kelurahan_sertifikat, c.kecamatan_sertifikat,
c.kota_sertifikat, c.propinsi_sertifikat, c.kode_pos_sertifikat, f.deskripsi_okupasi
FROM dpm_online.kredit AS a
INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
INNER JOIN webtool.asr_okupasi AS f ON b.okupasi = f.id
WHERE b.kode_asuransi = '004' AND b.jenis_jaminan='SERTIFIKAT' AND DATE(b.created_date) BETWEEN'2018-01-01' AND '2018-07-25'
