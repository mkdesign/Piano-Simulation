var instrumentGenerator = function(soundUrl){
	this.soundUrl = soundUrl;
	this.tempo    = 60;
	this.zarb     = 60/0.25;
	this.ratio    = this.zarb/this.tempo;
	this.context;
	this.bufferLoader;
}

instrumentGenerator.prototype.bufferLoaderGenerator = function(callbackFunction) {
	try {
        this.context = new AudioContext();
    }
    catch(e) {
        alert("Web Audio API is not supported in this browser");
    }
	this.bufferLoader = new BufferLoader(this.context,this.soundUrl,callbackFunction);
	this.bufferLoader.load();
};

instrumentGenerator.prototype.playSong = function(buffer, timeToPlay){
	console.log(timeToPlay);
	var source      = this.context.createBufferSource();
	source.buffer   = buffer;

	var gain        = this.context.createGain();
	gain.gain.value = 1.5;

	source.connect(gain);
	gain.connect(this.context.destination);

	source.start(this.context.currentTime+timeToPlay,0,1);	
}

instrumentGenerator.prototype.playNotes = function(notesArray, timeToPlay) {
	if( notesArray instanceof Array ){
    	for( var i=0; i<notesArray.length; i++ ){
        	this.playSong( this.bufferLoader.bufferList[notesArray[i]], timeToPlay );
    	}        
    }else{        	
        this.playSong(this.bufferLoader.bufferList[notesArray], timeToPlay ); 
    } 	
};

instrumentGenerator.prototype.playRythms = function(songNotesArray,songRhythmsArray){
	var duration = [];
	var notes = [];

	for( var i=0; i<songNotesArray.length; i++ ){
    	notes[i]    = songNotesArray[i].concat();
    	duration[i] = songRhythmsArray[i].concat();
    }

    for( var i=0; i<duration.length; i++ ){
    	for( j=1; j<duration[i].length; j++ ){
    		duration[i][j] = duration[i][j-1] + duration[i][j];
    	}
    }

    for( var i=0; i<notes.length; i++ ){
    	for( var j=0; j<notes[i].length; j++ ){
    		var timeToPlay =  duration[i][j]*this.ratio;
        	this.playNotes( notes[i][j],timeToPlay );
    	}
    }
}

instrumentGenerator.prototype.keyAnimate = function(array,i,time){
	var keys = $('.keys').find('.key');
	var that = this;
	setTimeout(function(){
		if(array[i]<88)
			keys.eq(array[i]).addClass('active');
		that.removeKeyAnimate(array,i,time);

		i++;

		if(i<array.length)
			that.keyAnimate(array,i,time);

	},time[i-1]*1000*that.ratio)
}

instrumentGenerator.prototype.removeKeyAnimate = function(array,i,time){
	var keys = $('.keys').find('.key');
	var that = this;
	setTimeout(function(){
		keys.eq(array[i]).removeClass('active');
	},time[i]*1000*that.ratio)
}