SELECT d.deskripsi_asuransi, a.no_rekening, c.nasabah_id, c.nama_nasabah,
c.alamat, c.telpon, c.jenis_kelamin, c.tempatlahir, c.tgllahir, c.desa, c.kecamatan, a.kode_kantor, a.tgl_realisasi,
a.tgl_jatuh_tempo, a.kode_asuransi, a.materai AS nilai_premi_kebakaran, a.premi AS nilai_premi_kendaraan,
a.nilai_asuransi, a.jml_pinjaman, a.jml_angsuran, a.premi, b.agunan_id , a.nilai_taksasi_agunan, b.nilai_taksasi_detail,
a.kode_asuransi_jiwa, a.nilai_asuransi_jiwa, a.tgl_mulai_asuransi_jiwa, b.jenis, b.kd_jenis, b.kd_merk_old,
b.nama_bpkb, b.alamat_bpkb, b.keterangan, b.nama_pemilik_sertifikat, b.alamat_sertifikat
FROM dpm_online.kredit  AS a
INNER JOIN dpm_online.jaminan_dokument AS b
	ON (a.agunan_id1 = b.agunan_id OR a.agunan_id2 = b.agunan_id OR a.agunan_id3 = b.agunan_id OR a.agunan_id4 = b.agunan_id OR a.agunan_id5 = b.agunan_id)
LEFT JOIN dpm_online.nasabah AS c ON a.nasabah_id = c.nasabah_id
INNER JOIN dpm_online.kre_kode_asuransi AS d ON a.kode_asuransi = d.kode_asuransi
WHERE a.pokok_saldo_akhir <> 0 AND a.kode_asuransi IN ('004','005')
