<?php
namespace Widget;

/**
 * @description 
 */
class Ftp // extends IFtp 
{
	private $ignore = [],
		$list = [];
	/**
	 * @description 
	 */
	public function __construct(\phpseclib3\Net\SFTP $Ftp, $root)
	{
		$this->con = $Ftp;
		$this->current_dir = $this->root = $root;
	}
	/**
	 * @description 
	 */
	public function addIgnore(string $type, string $path)
	{
		$this->ignore[$type][] = rtrim($path, '/');
		return $this;
	}
	/**
	 * @description 
	 */
	public function setRoot($path)
	{
		$this->root = $path;
		return $this;
	}
	/**
	 * @description 
	 */
	public function isFile()
	{
		return $this->con->is_file(func_get_args()[0]);
	}
	/**
	 * @description 
	 */
	public function isDir()
	{
		$path = func_get_args()[0];
		if (in_array($path, ['.', '..']))
			return false;

		return !$this->isFile($path);
	}
	/**
	 * @description 
	 */
	public function toParent()
	{
		$path = $this->con->chdir($this->getCurrentDir() . '/../');
		$this->current_dir = $path;
		return $this->con->nlist($path);
	}
	/**
	 * @description 
	 */
	public function openDir()
	{
		return $this->con->nlist(func_get_args()[0]);
	}
	/**
	 * @description 
	 */
	public function recurse()
	{
		$args = func_get_args();
		$flist = $args[0];
		$root = $args[1];
		$copy = ($args[2]) ?? false;

		if (!is_array($flist)) {
			return false;
		}
		foreach ($flist as $file) {
			if ($this->isInvalid($file))
				continue;

			$itm = rtrim($root, '/') . "/{$file}";
			$rtitm = '/' . basename($this->root) . str_replace($this->root, '', $itm);

			if ($this->isDir($itm)) {
				if (isset($this->ignore['path']) && in_array($rtitm, $this->ignore['path']))
					continue;

				$this->recurse($this->openDir($itm), $itm);
			} else {

				if (isset($this->ignore['file']) && in_array(basename($rtitm), $this->ignore['file']))
					continue;
				elseif (isset($this->ignore['extension']) && in_array(pathinfo($rtitm, PATHINFO_EXTENSION), $this->ignore['extension']))
					continue;

				$this->list['local'][] = $rtitm;
				$this->list['remote'][] = $itm;
			}
		}
		return $this;
	}
	/**
	 * @description 
	 */
	public function toLocal($local, \Nubersoft\nApp $nApp)
	{
		$report = [];
		foreach ($this->getCollection()['remote'] as $key => $path) {
			$file = str_replace('/', DS, rtrim($local, DS) . DS . ltrim($this->getCollection()['local'][$key], '/'));
			$report[(($this->fromTo($path, $file, $nApp)) ? 'success' : 'error')][] = $file;
		}
		return $report;
	}
	/**
	 * @description 
	 */
	public function fromTo($from, $to, \Nubersoft\nApp $nApp)
	{
		if ($nApp->isDir(pathinfo($to, PATHINFO_DIRNAME))) {
			$this->con->get($from, $to);
		}
		return (is_file($to));
	}
	/**
	 * @description 
	 */
	public function getCollection($type = false)
	{
		if ($type)
			return ($this->list[$type]) ?? [];

		return $this->list;
	}
	/**
	 * @description 
	 */
	public function isInvalid($file)
	{
		return in_array($file, ['.', '..']);
	}
	/**
	 * @description 
	 */
	public function getCurrentDir()
	{
		return rtrim($this->current_dir, '/');
	}
	/**
	 * @description 
	 */
	public function getDirectoryContents()
	{
		return $this->recurse($this->openDir($this->root), $this->root)->getCollection();
	}
	/**
	 * @description 
	 */
	public function fetch()
	{
		$this->getDirectoryContents();
		return $this;
	}
}
