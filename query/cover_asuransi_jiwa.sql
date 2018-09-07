SELECT DISTINCT
f.id, f.id_polis, a.kode_kantor, d.no_id, b.no_ktp, d.nama_nasabah, f.nama_area_kerja, d.tempatlahir, d.tgllahir, d.alamat, h.ktp_alamat, h.ktp_rt,
h.ktp_rw, h.ktp_desa, h.ktp_kecamatan, g.deskripsi_kode_dati  AS kota_kab, i.nama_provinsi AS ktp_propinsi, h.ktp_kodepos AS ktp_kodepos,
b.jenis_kelamin, b.tinggi_badan, b.berat_badan, d.hp AS no_telp, d.telpon, a.type_kredit, a.tgl_realisasi, a.tgl_jatuh_tempo,
a.tgl_jt_asuransi_jiwa AS tgl_jt_asuransi_jiwa, a.jml_angsuran, a.jml_pinjaman, a.nilai_taksasi_agunan, c.jenis, c.kd_jenis, a.nilai_asuransi_jiwa,
c.alamat_bpkb, c.alamat_sertifikat, e.deskripsi_asuransi, b.no_rekening, b.kode_asuransi, b.kode_group_cabang, b.nama_tertanggung,
b.rateAsuransi AS rate, b.ratePremiGross AS premiGross, b.ratePremiCigna AS premiCigna, b.extraPremi, b.totalPremi, b.totalLoan,
b.titipan_asuransi, b.biayaAdmin, b.keteranganJaminan, b.companyCode,  b.programCigna, b.created_date, b.created_by, b.file_spa, b.file_ktp,
IF(f.status_endorsement=1,'Ya', IF(f.status_endorsement=0,'Tidak',NULL)) AS status_endorsement
FROM dpm_online.kredit AS a
INNER JOIN webtool.asr_cover_jiwa AS b ON a.no_rekening = b.no_rekening
INNER JOIN dpm_online.jaminan_dokument AS c ON
	(a.agunan_id1 = c.agunan_id OR a.agunan_id2 = c.agunan_id OR a.agunan_id3 = c.agunan_id
	OR a.agunan_id4 = c.agunan_id OR a.agunan_id5 = c.agunan_id)
INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
INNER JOIN dpm_online.kre_kode_asuransi AS e ON e.kode_asuransi = b.kode_asuransi
INNER JOIN dpm_online.app_kode_kantor AS f ON f.kode_kantor = b.kode_group_cabang
INNER JOIN dpm_online.css_kode_dati AS g ON g.kode_dati = d.kota_kab
INNER JOIN dpm_online.nasabah_alamat AS h ON h.nasabah_id = d.nasabah_id
INNER JOIN dpm_online.css_kode_propvinsi AS i ON h.ktp_propinsi = i.kode_provinsi
LEFT JOIN webtool.asr_polis AS f ON b.no_rekening = f.no_rekening AND f.jenis_asuransi='2'
WHERE b.created_date LIKE '%2018-03%'
AND (b.no_rekening LIKE '%%' OR d.nama_nasabah LIKE '%%')
