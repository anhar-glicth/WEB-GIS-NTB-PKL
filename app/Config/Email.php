<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // Konfigurasi Pengirim (Sesuai Permintaan)
    public string $fromEmail = 'esdmmagang@gmail.com';
    public string $fromName = 'WEB GIS-NTB (OFFICIAL)';
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';

    // Protokol SMTP untuk Gmail
    public string $protocol = 'smtp';
    public string $mailPath = '/usr/sbin/sendmail';

    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'esdmmagang@gmail.com';

    /**
     * PENTING: Gunakan 16 Digit "APP PASSWORD" dari Google Security.
     * JANGAN menggunakan password email utama Anda.
     */
    public string $SMTPPass = 'aszn iecn vusf dqdd';

    public int $SMTPPort = 587; // Port TLS
    public int $SMTPTimeout = 20;
    public bool $SMTPKeepAlive = false;
    public string $SMTPCrypto = 'tls';

    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public bool $validate = true;

    public int $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;
    public bool $DSN = false;
}