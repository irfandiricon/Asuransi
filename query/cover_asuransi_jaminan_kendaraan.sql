SELECT a.kode_kantor, b.no_rekening, a.tgl_realisasi, a.tgl_jatuh_tempo, d.nama_nasabah,
a.jml_angsuran, a.kode_asuransi, e.deskripsi_asuransi, b.nilai_pertanggungan,
b.titipan_asuransi, c.kd_jenis, c.kd_merk, c.kd_type,
c.no_rangka, c.no_mesin, c.warna, c.tahun, c.no_polisi, c.alamat_bpkb, b.selisih, b.kode_pertanggungan, b.nama_pertanggungan
FROM dpm_online.kredit AS a
INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
INNER JOIN webtool.asr_jenis_pertanggungan_inventaris AS f ON f.id_pertanggungan = b.kode_pertanggungan
