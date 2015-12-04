var app = angular.module('applicationAN',[]);

var ladedData = {
	teams : [
		{name: 'SRS',laps:0,time:0},
		{name: 'Fresh',laps:0,time:0},
		{name: 'TopNode',laps:0,time:0}
	],
	numberLaps : 10
}

app.controller('TabController', function(){
	this.tab = 1;

	this.setTab = function(newValue){
		this.tab = newValue;
	};

	this.isSet = function(tabName){
		return this.tab === tabName;
	};
});

app.controller('TeamsController', function($scope) {
	var it = $scope;
	it.teams = [];
	it.name = '';
	it.addTeam = function(inputStr) {
		it.teams.push( {name:inputStr,laps:0,time:0});
		console.log(it.teams);
		it.name = '';
	}
	it.delTeam = function(index) {
		it.teams.splice(index,1);
	}

	it.save = function() {
		ladedData = it.teams;
	}
});


app.controller('RaceController', function() {

	this.bestLap = 0;
	this.indexBest = 0;
	this.team = ladedData;
	this.startTime = 0;
	this.startRace = function () {
		this.startTime = Date.now();
	}


	this.addLap = function(index){
		// check if race is started and team laps are less then maxium race
		if ( this.raceIs() && ( this.team.teams[index].laps < this.team.numberLaps )) {

			//chek best lap
			var laptime = Date.now() - this.team.teams[index].time - this.startTime;
			this.bestLap = (
				laptime <= this.bestLap || this.bestLap === 0 ?
				laptime :
				this.bestLap
			);
			this.indexBest = index;

			// UPDATE DATE AND LAPS OF ROBOT
			this.team.teams[index].time = Date.now() - this.startTime;
			this.team.teams[index].laps = this.team.teams[index].laps + 1;
			this.team.teams[index].finished = false;

			// CHECK IF ROBOT END THE RACE
			if (this.team.teams[index].laps === this.team.numberLaps) {
				this.team.teams[index].finished = true;
			}
		}
	};

	// check if the race is started
	this.raceIs = function () {
		return this.startTime > 0 ? true : false;
	}

});


app.controller('QualificationController', function($scope, $interval) {

	var it = $scope;

	it.team = ladedData;
	it.counter = 0;

	var startTime = 0;

	it.start = function (index) {
		if(it.counter == 0) {
			it.index = index;
			it.counter = 0;
			startTime = Date.now();;
			it.timerId = $interval(it.counting);
		}
	}

	it.stop = function (index) {
		if(it.counter > 0) {
			it.team.teams[it.index].t1 = it.counter;
			$interval.cancel(it.timerId);
			it.counter = 0;
		}
	}

	it.counting = function () {
		it.counter = Date.now() - startTime;
	}
});

