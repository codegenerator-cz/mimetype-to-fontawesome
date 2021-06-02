<?php declare(strict_types=1);

class MimetypeToFontAwesome {
	/** @var string  */
	public const FILE = 'fa-file-o';
	/** @var string  */
	public const FILE_IMAGE = 'fa-file-image-o';
	/** @var string  */
	public const FILE_AUDIO = 'fa-file-audio-o';
	/** @var string  */
	public const FILE_VIDEO = 'fa-file-video-o';
	/** @var string  */
	public const FILE_PDF = 'fa-file-pdf-o';
	/** @var string  */
	public const FILE_ALT = 'fa-file-alt-o';
	/** @var string  */
	public const FILE_CODE = 'fa-file-code-o';
	/** @var string  */
	public const FILE_ARCHIVE = 'fa-file-archive-o';
	/** @var string  */
	public const FILE_WORD = 'fa-file-word-o';
	/** @var string  */
	public const FILE_POWERPOINT = 'fa-file-powerpoint-o';
	/** @var string  */
	public const FILE_EXCEL = 'fa-file-excel-o';

	/**
	 * @var array<string, string[]>
	 */
	public const mappingV5 = [
		// Images
		self::FILE_IMAGE => ['/^image\//'],
		// Audio
		self::FILE_AUDIO => ['/^audio\//'],
		// Video
		self::FILE_VIDEO => ['/^video\//'],
		// Documents
		self::FILE_PDF => ['application/pdf'],
		self::FILE_ALT => ['text/plain'],
		self::FILE_CODE => [
			'text/html',
			'text/javascript'
		],
		// Archives
		self::FILE_ARCHIVE => [
			'/^application\/x-(g?tar|xz|compress|bzip2|g?zip)$/',
			'/^application\/x-(7z|rar|zip)-compressed$/',
			'/^application\/(zip|gzip|tar)$/',
		],
		// Word
		self::FILE_WORD => [
			'application/vnd.oasis.opendocument.text',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'/ms-?word/,<',
		],
		// Powerpoint
		self::FILE_POWERPOINT => [
			'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'/ms-?powerpoint/',
		],
		// Excel
		self::FILE_EXCEL => [
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'/ms-?excel/',
		],
		// Default
		self::FILE => ['*'],
	];

	public static function match(string $subject): string {
		return match (true) {
			// Documents
			str_contains($subject, self::mappingV5[self::FILE_PDF][0]) => self::FILE_PDF,
			str_contains($subject, self::mappingV5[self::FILE_ALT][0]) => self::FILE_ALT,
			str_contains($subject, self::mappingV5[self::FILE_CODE][0]),
			str_contains($subject, self::mappingV5[self::FILE_CODE][1]) => self::FILE_CODE,
			// Images
			is_integer(preg_match(self::mappingV5[self::FILE_IMAGE][0], $subject)) => self::FILE_IMAGE,
			// Audio
			is_integer(preg_match(self::mappingV5[self::FILE_AUDIO][0], $subject)) => self::FILE_AUDIO,
			// Video
			is_integer(preg_match(self::mappingV5[self::FILE_VIDEO][0], $subject)) => self::FILE_VIDEO,
			// Archives
			is_integer(preg_match(self::mappingV5[self::FILE_ARCHIVE][0], $subject)),
			is_integer(preg_match(self::mappingV5[self::FILE_ARCHIVE][1], $subject)),
			preg_match(self::mappingV5[self::FILE_ARCHIVE][2], $subject) => self::FILE_ARCHIVE,
			// Word
			str_contains($subject, self::mappingV5[self::FILE_WORD][0]),
			str_contains($subject, self::mappingV5[self::FILE_WORD][1]),
			is_integer(preg_match(self::mappingV5[self::FILE_WORD][2], $subject)) => self::FILE_WORD,
			// Powerpoint
			str_contains($subject, self::mappingV5[self::FILE_POWERPOINT][0]),
			is_integer(preg_match(self::mappingV5[self::FILE_POWERPOINT][1], $subject)) => self::FILE_POWERPOINT,
			// Excel
			str_contains($subject, self::mappingV5[self::FILE_EXCEL][0]),
			is_integer(preg_match(self::mappingV5[self::FILE_EXCEL][1], $subject)) => self::FILE_EXCEL,
			default => self::FILE,
		};
	}
}