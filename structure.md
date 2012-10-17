Request
	Cache
	Log
	Recordlist extends Filelist
		Record contains
			url
			title
			Model
			Controller
			View

		Post extends Record contains

		Page extends Record
		File extends Record
	Template

Request->Cache
Request->RecordList->get($id)