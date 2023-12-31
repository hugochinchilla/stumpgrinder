<?php

declare(strict_types = 1);

namespace hugochinchilla\stumpgrinder;

class Ownership
{
    private string $path;
    public int $uid;
    public int $gid;
    public int $newUid;
    public int $newGid;

    public function __construct(string $path)
    {
        $this->path = $path;
        $parentPath = dirname(realpath($path));
        $this->newUid = fileowner($parentPath);
        $this->newGid = filegroup($parentPath);
        $this->uid = fileowner($path);
        $this->gid = filegroup($path);
    }

    public function needsUpdate(): bool
    {
        if (is_dir($this->path)) {
            return true;
        }

        return $this->newUid !== $this->uid || $this->newGid !== $this->gid;
    }
}