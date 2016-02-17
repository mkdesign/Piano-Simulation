<?php
	if( isset($_POST['notes']) )
	{
		$notes = $_POST['notes'];
		if( is_string($notes) )
		{
			$fileName = md5(time().rand(1,255)).".txt";
			file_put_contents($fileName, $notes);

			header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($fileName));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($fileName));
		    readfile($fileName);

		}
	} else if( isset($_FILES['textfile']) )
	{
		var_dump($_FILES);
		$target_file = basename($_FILES["textfile"]["name"]);
		if (move_uploaded_file($_FILES["textfile"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["textfile"]["name"]). " has been uploaded.";
	    	$ustring = file_get_contents($target_file);
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
?>


<!doctype html>
<html lang="en-US" direction="ltr">
<head>
	<meta charset="utf-8" />
	<title>First rythms</title>
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="style.css">
	<script src="jquery.js" ></script>
	<script src="vexflow/releases/vexflow-min.js"></script>
	<script src="raphael-min.js"></script>
	<script src="composer-class.js"></script>
	<script src="buffer-load.js" ></script>
	<script src="instrument-generator.js"></script>
	
</head>
<body>

	<div class="keys composer_keyboard">

		<div class="key"></div>
		<div class="key black b0"></div>
		<div class="key"></div>
		<div class="key black b1"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b2"></div>
		<div class="key"></div>
		<div class="key black b3"></div>
		<div class="key"></div>
		<div class="key black b4"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b5"></div>
		<div class="key"></div>
		<div class="key black b6"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b7"></div>
		<div class="key"></div>
		<div class="key black b8"></div>
		<div class="key"></div>
		<div class="key black b9"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b10"></div>
		<div class="key"></div>
		<div class="key black b11"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b12"></div>
		<div class="key"></div>
		<div class="key black b13"></div>
		<div class="key"></div>
		<div class="key black b14"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b15"></div>
		<div class="key"></div>
		<div class="key black b16"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b17"></div>
		<div class="key"></div>
		<div class="key black b18"></div>
		<div class="key"></div>
		<div class="key black b19"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b20"></div>
		<div class="key"></div>
		<div class="key black b21"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b22"></div>
		<div class="key"></div>
		<div class="key black b23"></div>
		<div class="key"></div>
		<div class="key black b24"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b25"></div>
		<div class="key"></div>
		<div class="key black b26"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b27"></div>
		<div class="key"></div>
		<div class="key black b28"></div>
		<div class="key"></div>
		<div class="key black b29"></div>
		<div class="key"></div>

		<div class="key"></div>
		<div class="key black b30"></div>
		<div class="key"></div>
		<div class="key black b31"></div>
		<div class="key"></div>
		<div class="key"></div>
		<div class="key black b32"></div>
		<div class="key"></div>
		<div class="key black b33"></div>
		<div class="key"></div>
		<div class="key black b34"></div>
		<div class="key"></div>
		<div class="key"></div>

		<div class="clear"></div>
	</div>
	<p>Run</p>
	<div class="control">
		<div class="play"></div>
	</div>
	<div class="stave">
		<canvas width="700" height="200"></canvas>
	</div>
	<div class="notation">
		<div class="choose_note">
			<label>Choose Note :</label>
			<select id="notes">
				<option selected="selected">A</option>
				<option>A#</option>
				<option>B</option>
				<option>C</option>
				<option>C#</option>
				<option>D</option>
				<option>D#</option>
				<option>E</option>
				<option>F</option>
				<option>F#</option>
				<option>G</option>
				<option>G#</option>
			</select>
		</div>
		<div class="choose_octave">
			<label>Choose Octave :</label>
			<select id="octaves">
				<option selected="selected">1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
		</div>
		<div class="choose_duration">
			<label>Choose Duration : </label>
			<select id="duration">
				<option selected="selected"  value="w">Whole</option>
				<option value="h">Half</option>
				<option value="q">Quarter</option>
				<option value="8d">Eighth</option>
				<option value="16">Sixteenth</option>
			</select>
		</div>
		<input type="button" value="Add Note" id="add_note">
		<button id="edit_note">edit</button>
		<button id="cursor_animate">cursor</button>
		<form action='' method='POST'>
			<button id="download">Downlaod</button>
		</form>
		<form action='' method='POST' enctype="multipart/form-data">
			<input type='file' name='textfile'/>
			<br/>
			<input type='submit' value='Upload File'/>
		</form>
	</div>

	<script type="text/javascript">
		
			var songNotes=[];
			var songRhythm=[];
			var keys = $('.keys').find('.key');

			var soundFiles = [
				'../piano/sound/A0.mp3','../piano/sound/Bb0.mp3','../piano/sound/B0.mp3','../piano/sound/C1.mp3','../piano/sound/Db1.mp3','../piano/sound/D1.mp3','../piano/sound/Eb1.mp3','../piano/sound/E1.mp3','../piano/sound/F1.mp3','../piano/sound/Gb1.mp3','../piano/sound/G1.mp3','../piano/sound/Ab1.mp3','../piano/sound/A1.mp3','../piano/sound/Bb1.mp3','../piano/sound/B1.mp3','../piano/sound/C2.mp3','../piano/sound/Db2.mp3','../piano/sound/D2.mp3','../piano/sound/Eb2.mp3','../piano/sound/E2.mp3','../piano/sound/F2.mp3','../piano/sound/Gb2.mp3','../piano/sound/G2.mp3','../piano/sound/Ab2.mp3','../piano/sound/A2.mp3','../piano/sound/Bb2.mp3','../piano/sound/B2.mp3','../piano/sound/C3.mp3','../piano/sound/Db3.mp3','../piano/sound/D3.mp3','../piano/sound/Eb3.mp3','../piano/sound/E3.mp3','../piano/sound/F3.mp3','../piano/sound/Gb3.mp3','../piano/sound/G3.mp3','../piano/sound/Ab3.mp3','../piano/sound/A3.mp3','../piano/sound/Bb3.mp3','../piano/sound/B3.mp3','../piano/sound/C4.mp3','../piano/sound/Db4.mp3','../piano/sound/D4.mp3','../piano/sound/Eb4.mp3','../piano/sound/E4.mp3','../piano/sound/F4.mp3','../piano/sound/Gb4.mp3','../piano/sound/G4.mp3','../piano/sound/Ab4.mp3','../piano/sound/A4.mp3','../piano/sound/Bb4.mp3','../piano/sound/B4.mp3','../piano/sound/C5.mp3','../piano/sound/Db5.mp3','../piano/sound/D5.mp3','../piano/sound/Eb5.mp3','../piano/sound/E5.mp3','../piano/sound/F5.mp3','../piano/sound/Gb5.mp3','../piano/sound/G5.mp3','../piano/sound/Ab5.mp3','../piano/sound/A5.mp3','../piano/sound/Bb5.mp3','../piano/sound/B5.mp3','../piano/sound/C6.mp3','../piano/sound/Db6.mp3','../piano/sound/D6.mp3','../piano/sound/Eb6.mp3','../piano/sound/E6.mp3','../piano/sound/F6.mp3','../piano/sound/Gb6.mp3','../piano/sound/G6.mp3','../piano/sound/Ab6.mp3','../piano/sound/A6.mp3','../piano/sound/Bb6.mp3','../piano/sound/B6.mp3','../piano/sound/C7.mp3','../piano/sound/Db7.mp3','../piano/sound/D7.mp3','../piano/sound/Eb7.mp3','../piano/sound/E7.mp3','../piano/sound/F7.mp3','../piano/sound/Gb7.mp3','../piano/sound/G7.mp3','../piano/sound/Ab7.mp3','../piano/sound/A7.mp3','../piano/sound/Bb7.mp3','../piano/sound/B7.mp3','../piano/sound/C8.mp3', '../piano/sound/silence.wav'
			]
			songNotes[0]=[];
			songRhythm[0]=[];


			var pianoGenerator = new instrumentGenerator(soundFiles);

			var canvasTag = $('canvas')[0];

			var pianoComposer = new composerClass(canvasTag,$('#notes'),$('#octaves'),$('#duration'));
			var uploaded_flag = false;
			document.ready = function(){
				if(!uploaded_flag) pianoComposer.generateStave();
				pianoGenerator.bufferLoaderGenerator(bufferLoadCompleted);
			}

			function bufferLoadCompleted (){
				keys.each(function(){
					$(this).click(function(){
						var keyIndex = $(this).index();
						pianoGenerator.playNotes(keyIndex,0)
					})
				})	
			}

			$('#add_note').click(function(){
				pianoComposer.generateStave();
				pianoComposer.addNotes();
				pianoComposer.generateNotes();
				pianoComposer.generatePositions();

				var prg = $('select#notes').val();
				var choosednote;
				if(prg == 'A') {
					choosednote = 10;
				}
				if(prg == 'A#') {
					choosednote = 11;
				}
				else if (prg == 'B') {
					choosednote = 12;
				}
				else if (prg == 'C') {
					choosednote = 1;
				}
				else if (prg == 'C#') {
					choosednote = 2;
				}
				else if (prg == 'D') {
					choosednote = 3;
				}
				else if (prg == 'D#') {
					choosednote = 4;
				}
				else if (prg == 'E') {
					choosednote = 5;
				}
				else if (prg == 'F') {
					choosednote = 6;
				}
				else if (prg == 'F#') {
					choosednote = 7;
				}
				else if (prg == 'G') {
					choosednote = 8;
				}
				else if (prg == 'G#') {
					choosednote = 9;
				}

				var octavevalue = $('select#octaves').val();
				songNotes[0].push((octavevalue-1)*7+choosednote);
				// console.log(songNotes);

				var notestime = $('select#duration').val();
				if(notestime == 'w') {
					songRhythm[0].push(1);
				}
				else if(notestime == 'h') {
					songRhythm[0].push(0.5);
				}
				else if(notestime == 'q') {
					songRhythm[0].push(0.25);
				}
				else if(notestime == '8d') {
					songRhythm[0].push(0.125);
				}
				else if(notestime == '16') {
					songRhythm[0].push(0.0625);
				}

			})

			$('#edit_note').click(function(){
				pianoComposer.generateStave();
				pianoComposer.editNote();
				pianoComposer.generateNotes();
				pianoComposer.generatePositions();
				pianoComposer.highlighter();
			})

			$('canvas').click(function(){
				pianoComposer.findSelectedNote(event.clientX);
				pianoComposer.generateStave();
				pianoComposer.generateNotes();
				pianoComposer.highlighter();
			})

			var staveCursor = function(){
				var duration = [];
				for(var i=0; i<songRhythm[0].length; i++) {
					duration[i] = songRhythm[0][i];
					

				}
				for(var i=1; i<duration.length; i++) {
					duration[i] = duration[i-1] + duration[i];
					console.log(duration[i])
				}

				for(var i=0; i<duration.length; i++) {
					(function(j){
						setTimeout(function(){
							pianoComposer.generateStave();
							pianoComposer.generateNotes();
							pianoComposer.highlighter(j);
						},duration[j]*4000)
					})(i);
				}
			}
			$('.play').click(function(){
				var newNotes = [],
					newRythms = [];

				newNotes[0]  = songNotes[0].concat();
				newRythms[0] = songRhythm[0].concat();

				pianoGenerator.playRythms(newNotes,newRythms);
				staveCursor();
				// pianoGenerator.keyAnimate(songNotes[0],0,songRhythm[0])
			})

			$('#download').click(function(){
				pianoComposer.generateInput();
			})
			var upload_files_keys = <?php echo (isset($ustring))?$ustring:"' '"  ?>;

			(function () {
				var upload_octave,
					upload_note,
					upload_duration;

				if(upload_files_keys instanceof Array) {
					uploaded_flag= true;
					for(var i =0;i<upload_files_keys.length;i++) {
						upload_note     = upload_files_keys[i][0].charAt(0);
						upload_octave   = upload_files_keys[i][0].charAt(2);
						upload_duration = upload_files_keys[i][1];


						if(upload_files_keys[i].length < 3) {
							
							$('#notes').val(upload_note);
							$('#octaves').val(upload_octave);
							$('#duration').val(upload_duration);
							pianoComposer.generateStave();
							pianoComposer.addNotes();
							pianoComposer.generateNotes();
							pianoComposer.generatePositions();

						}
						else {
							$('#notes').val(upload_note+'#');
							$('#octaves').val(upload_octave);
							$('#duration').val(upload_duration);
							pianoComposer.generateStave();
							pianoComposer.addNotes();
							pianoComposer.generateNotes();
							pianoComposer.generatePositions();
						}

					}
				}
			})();


	</script>
</body>
</html>