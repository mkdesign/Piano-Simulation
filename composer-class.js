var composerClass = function(canvastag,userNote,userOctave,userNoteDuration){

	this.canvastag        = canvastag;
	this.renderer         = new Vex.Flow.Renderer(this.canvastag , Vex.Flow.Renderer.Backends.CANVAS);
	this.ctx              = this.renderer.getContext();
	this.stave            = new Vex.Flow.Stave(10,0,500);
	this.notes            = [];
	this.userNote         = userNote;
	this.userOctave       = userOctave;
	this.userNoteDuration = userNoteDuration;
	this.notesPositions   = [];
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
	this.notes.push(new Vex.Flow.StaveNote({

		keys: [ this.userNote.val() +"/"+ this.userOctave.val() ],
		duration: this.userNoteDuration.val() 
	}));

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

composerClass.prototype.highlighter = function() {
	var position = this.notesPositions[this.clickedNote];
	this.ctx.fillStyle = "#ff0000";
 	this.ctx.fillRect(position-10, 40, 4, 40);
 	this.ctx.fillStyle = "#000";
};