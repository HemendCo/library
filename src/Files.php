<?php

namespace Hemend\Library;

class Files {
	public static function generateFilenameAndpath(string $path, string $hash_id = '') {
		do {
			$filename = self::generateFilename($hash_id);
			$filepath = self::generateFilepath($path, $filename);
		} while(!$filepath);
		
		return (object) ['name' => $filename, 'path' => $filepath];
	}
	
	public static function generateFilename(string $hash_id = '') {
    if(!strlen($hash_id)) {
      $hash_id = Strings::generateRandomCode(8);
    }

    return Strings::generateRandomCode(16) . '-' .
      $hash_id . '-' . // 8 Character [1-9a-z]
      Strings::generateRandomCode(6);
	}

    /**
     * @throws \Exception
     */
    public static function generateFilepath(string $path, string $filename) {
        preg_match_all('/([a-z1-9]{1,1})/', $filename, $matches);
        $folders = array_slice($matches[0], 0, 3);

        $folder_prefix = implode(DS, $folders);
        $folder = $path . DIRECTORY_SEPARATOR . $folder_prefix;

        if(!self::makeDir($folder)) {
          throw new \Exception('Could not make folders');
        }

        $filepath = $folder . DIRECTORY_SEPARATOR . $filename;

        if(file_exists($filepath)) {
          return false;
        }

        return $folder_prefix . DIRECTORY_SEPARATOR . $filename;
    }
	
    public static function makeDir($dirpath, $mode=0755) {
        return is_dir($dirpath) || mkdir($dirpath, $mode, true);
    }
}
