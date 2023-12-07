<?php

namespace Hemend\Library;

class Glob
{
  static public function recursive($base, $pattern, $flags = 0): array|false {
    $glob_nocheck = $flags & GLOB_NOCHECK;
    $flags = $flags & ~GLOB_NOCHECK;

    $files = self::checkFolder($base, $pattern, $flags);

    if ($glob_nocheck && count($files) === 0) {
      return [$pattern];
    }

    return $files;
  }

  static protected function checkFolder($base, $pattern, $flags): bool|array
  {
    if (substr($base, -1) !== DIRECTORY_SEPARATOR) {
      $base .= DIRECTORY_SEPARATOR;
    }

    $files = glob($base.$pattern, $flags);
    if (!is_array($files)) {
      $files = [];
    }

    $dirs = glob($base.'*', GLOB_ONLYDIR|GLOB_NOSORT|GLOB_MARK);
    if (!is_array($dirs)) {
      return $files;
    }

    foreach ($dirs as $dir) {
      $dirFiles = self::checkFolder($dir, $pattern, $flags);
      $files = array_merge($files, $dirFiles);
    }

    return $files;
  }
}