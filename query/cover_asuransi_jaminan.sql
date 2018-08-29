SELECT a.kode_kantor, b.no_rekening, a.tgl_realisasi, a.tgl_jatuh_tempo, c.agunan_id, d.nama_nasabah, d.alamat, d.tgllahir, c.jenis,
a.jml_angsuran, a.jml_pinjaman, a.nilai_taksasi_agunan, a.kode_asuransi, e.deskripsi_asuransi, b.rate, b.nilai_pertanggungan,
b.premi, b.titipan_asuransi, b.total_titipan, b.komisi, b.net_premi, b.created_date, b.created_by, c.kd_jenis, c.kd_merk, c.kd_type,
c.no_rangka, c.no_mesin, c.warna, c.tahun, c.no_polisi, c.alamat_bpkb, c.alamat_sertifikat, c.kelurahan_sertifikat, c.kecamatan_sertifikat,
c.kota_sertifikat, c.propinsi_sertifikat, c.kode_pos_sertifikat, b.okupasi, b.kode_pertanggungan, b.selisih
FROM dpm_online.kredit AS a
INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
