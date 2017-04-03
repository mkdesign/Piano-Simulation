var composerClass = function(canvastag,userNote,userOctave,userNoteDuration){

	this.canvastag        = canvastag;
	this.renderer         = new Vex.Flow.Renderer(this.canvastag , Vex.Flow.Renderer.Backends.CANVAS);
	this.ctx              = this.renderer.getContext();
	this.stave            = new Vex.Flow.Stave(10,0,1000);
	this.notes            = [];
	this.userNote         = userNote; // user input for notes
	this.userOctave       = userOctave;// user input for note's octave
	this.userNoteDuration = userNoteDuration;//user input for note duration
	this.notesPositions   = []; // all notes' positions
	this.clickedNote      = undefined;
	this.stave.addClef("treble");
}

composerClass.prototype.generateStave = function() {
	this.ctx.clear(); // first clear the context otherwise previouse notes will copy agin
	this.stave.setContext(this.ctx).draw();
};

composerClass.prototype.generateNotes = function() {
	Vex.Flow.Formatter.FormatAndDraw(this.ctx, this.stave, this.notes);

};

composerClass.prototype.addNotes = function(){
	var str = this.userNote.val();
	if(str.charAt(1)=='#') {
		this.notes.push(new Vex.Flow.StaveNote({

			keys: [ str.charAt(0) +"/"+ this.userOctave.val() ],
			duration: this.userNoteDuration.val(),

		}).addAccidental(0, new Vex.Flow.Accidental("#"))

		);
	}

	else {
		this.notes.push(new Vex.Flow.StaveNote({

			keys: [ this.userNote.val() +"/"+ this.userOctave.val() ],
			duration: this.userNoteDuration.val(),

		}));
	}

	

	this.clickedNote = undefined;
}

composerClass.prototype.editNote = function(){
	if(this.clickedNote == undefined){
		alert('you must first choose a note!');
	}

	this.notes[this.clickedNote] = new Vex.Flow.StaveNote({
		keys: [ this.userNote.val() +"/"+ this.userOctave.val() ],
		duration: this.userNoteDuration.val() 
	})
}

composerClass.prototype.generatePositions = function() {
	for(var i=0; i<this.notes.length; i++) {
		this.notesPositions[i] = this.notes[i].getAbsoluteX();
	}
};

composerClass.prototype.findSelectedNote = function(click_position) {

	for(var i=0; i< this.notesPositions.length; i++) {

		if( click_position < this.notesPositions[i] && click_position > this.notesPositions[i-1]) {
			if( click_position <= ( this.notesPositions[i-1] + ((this.notesPositions[i]-this.notesPositions[i-1])/2))) {
				this.clickedNote = i-1;
			}
			else {
				this.clickedNote = i;
			}
		}
	}

	return this.clickedNote;
};

composerClass.prototype.highlighter = function(cursorPosition) {
	if(cursorPosition==undefined) {
		var position = this.notesPositions[this.clickedNote];
	}

	else {
		console.log(cursorPosition);
		var position = this.notesPositions[cursorPosition];
	}	
	this.ctx.fillStyle = "#ff0000";
 	this.ctx.fillRect(position-10, 40, 4, 40);
 	this.ctx.fillStyle = "#000";
};

composerClass.prototype.generateInput = function() {
	var key = [];
	$.each(this.notes, function() {
		
		if( "modifiers" in this ) {
			if(this["modifiers"].length > 0 )
			{
				
				key.push( [this['keys'][0], this['duration'], "#"] );
			} else
			{
				
				key.push( [this['keys'][0], this['duration'] ] );
			}
		}
		
	});
	console.log(JSON.stringify(key));
	$("form").append("<input type='hidden' name='notes' value='"+JSON.stringify(key)+"'/>");
};