<?php

$thisObj	=	$this;
# This will fetch the master from git
if(!function_exists('fetch_and_install')) {
	/**
	 *	@description	Fetches the master zip, downloads, and installs it
	 *	@param	$repository	[string]	The name of the repository (cms or nubersoft)
	 *	@param	$root	[string]		Depending on if the site is installed with
	 *									Composer or not, it will determine where to drop files
	 *	@param	$thisObject	[\Nubersoft\nApp]	Class instance to access required methods
	 *	@param	$master	[string|null]	This is if not installed with Composer, needs to pull from src folder
	 */
	function fetch_and_install($repository, $root, $thisObj, $master = false)
	{
		# Set repo url
		$from	=	'https://github.com/rasclatt/'.$repository.'/archive/master.zip';
		# Set local zip download name
		$to		=	NBR_CLIENT_CACHE.DS.'installer'.DS.$repository.'master.zip';
		# Get the download directory path
		$dir	=	pathinfo($to, PATHINFO_DIRNAME);
		# Fetch the zip from git
		$downld	=	file_get_contents($from);
		# Create a download folder for the repo
		$thisObj->isDir($dir, true);
		# Stop if the download or dir create failed
		if(empty($downld)) {
			echo 'Updater failed to retrieve.';
			return false;
		}
		# Move the file to the download spot
		file_put_contents($to, $downld);
		# Stop if moving the file into place failed
		if(!is_file($to)) {
			echo 'Updater failed to download.';
			return false;
		}
		# Create an extract path
		$extracto	=	$dir.DS.$repository.'extracted';
		# Set the path where the repo is extracting from
		$finalFrom	=	$extracto.DS.$repository.'-master'.$master;
		# Create zip instance
		$Archive	=	new ZipArchive();
		# Open path to extract into
		$response	=	$Archive->open($to);
		# If we are into the zip
		if($response === true && $Archive->numFiles > 0) {
			# Create the folder where we are going to extract all the files/folders to
			$thisObj->isDir($extracto, true);
			# Extract all files
			$Archive->extractTo($extracto);
			# Finish that zip
			$Archive->close();
			# Stop if things didn't work out
			if(!is_dir($finalFrom)) {
				echo 'Updater failed to extract.';
				return false;
			}
			# Recursively loop extracted zip folder
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($finalFrom, RecursiveDirectoryIterator::KEY_AS_PATHNAME | RecursiveDirectoryIterator::SKIP_DOTS)) as $key => $value) {
				# Get file/folder info so things can be put in their rightful spots
				$path		=	pathinfo($key);
				$copy_from	=	$key;
				# Strip extract path, append to local directory path
				$copy_to	=	$thisObj->toSingleDs($root.DS.str_replace($finalFrom, '', $path['dirname']));
				# If this folder is not created, do so
				$thisObj->isDir($copy_to, true);
				# Append the file name
				$copy_dest	=	str_replace(DS.DS, DS, $copy_to.DS.$path['basename']);
				# Copy from the extraction to the destination
				if(copy($copy_from, $copy_dest)) {
					echo 'Copied file: '.$copy_dest.(!is_file($copy_dest)? ' <span style="color: green">(NEW)</span>' : '').'<br />';
				}
				else
					echo '<span style="color: red">Skipped file: '.$copy_dest.'</span><br />';

			}

			echo '<a href="'.$thisObj->getHelper('nRouter')->getPage(1, 'is_admin')['full_path'].'?action=clear_cache" class="medi-btn green">Back to Admin</a>';

			if(is_file($flag = NBR_CORE.DS.'installer'.DS.'firstrun.flag'))
				unlink($flag);
		}
		else
			echo $Archive;
	}
}
$err	=	$this->getDataNode('update_error');
if(!empty($err)): ?>
<div class="nbr_error"><?php echo $err ?></div>
<?php endif ?>

<h1>Update system software</h1>
<form action="?action=update_system_software" method="post">
	<label style="font-size: 1.25em; margin-bottom: 0.5em;">
		<input type="checkbox" name="update[cms]" checked="checked" value="cms" />&nbsp;CMS Updater v.<?php echo file_get_contents(__DIR__.DS.'..'.DS.'..'.DS.'settings'.DS.'version.flag') ?> (<a href="https://github.com/rasclatt/cms/" target="_blank">rasclatt/cms</a>)
	</label>
	<label style="font-size: 1.25em; margin-bottom: 0.5em;">
		<input type="checkbox" name="update[nubersoft]" value="nubersoft" />&nbsp;Framework Updater (<a href="https://github.com/rasclatt/nubersoft/" target="_blank">rasclatt/nubersoft</a>)
	</label>
	<?php if(is_dir(NBR_ROOT_DIR.DS.'vendor'.DS.'rasclatt'.DS.'nubersoft')): ?><div class="nbr_error">The class library appears to be installed by Composer! You can use <code style="font-family: Courier; background-color: #888; padding: 0 5px;">composer update rasclatt/nubersoft</code> in the terminal. If you update this way, it will still work, but Composer is preferred.</div><?php endif ?>
	<input type="submit" class="medi-btn green" value="Update Nubersoft" style="text-transform: uppercase;" />
</form>
<div class="pad-top" id="update-log">
<?php
if($this->getGet('action') == 'update_system_software') {
	
	foreach($this->getPost('update') as $package) {
		
		$is_composer	=	(is_dir(NBR_ROOT_DIR.DS.'vendor'.DS.'rasclatt'.DS.$package));
		
		if($is_composer) {
			$master		=	"";
			$root		=	($package == 'cms')? NBR_ROOT_DIR : NBR_ROOT_DIR.DS.'vendor'.DS.'rasclatt'.DS.$package;
		}
		else {
			$master		=	($package == 'cms')? "" : DS.'src';
			$root		=	($package == 'cms')? NBR_ROOT_DIR : NBR_ROOT_DIR.DS.'vendor'.DS.'Nubersoft';
		}
		
		fetch_and_install($package, $root, $this, $master);
	}
}
else
	echo 'Waiting...';
?>
</div>