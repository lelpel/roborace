var app = angular.module('applicationAN',[]);

app.service('teamData', function($rootScope) {
	var data = [];
	return {
		getTeams:function() {
			return data;
		},
		setTeams:function(teams) {
			data = teams;
			$rootScope.$broadcast('dataIsUpdated');
		}
	}
});

app.controller('TabController', function($scope, teamData){
	var it = this;
	it.tab = 1;

	it.setTab = function(newValue){
		it.tab = newValue;
	};

	it.isSet = function(tabName){
		return it.tab === tabName;
	};
});

app.controller('TeamsController', function($scope, teamData) {
	var it = $scope;
	it.teams = [];
	it.$on('dataIsUpdated', function() {
		it.teams = teamData.getTeams();
	});

	it.name = '';

	it.addTeam = function(inputStr) {
		it.teams.push( {name:inputStr,laps:0,time:0,t1:[],max:0});
		console.log(it.teams);
		it.name = '';
	}

	it.delTeam = function(index) {
		it.teams.splice(index,1);
	}

	it.save = function() {
		teamData.setTeams(it.teams);
	}
});

app.controller('QualificationController', function($scope, $interval,teamData) {

	var it = $scope;
	it.teams = [];
	it.selectedTeam = 0;
	it.$on('dataIsUpdated', function() {
		it.teams = teamData.getTeams();
	});

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
			$interval.cancel(it.timerId);
			it.teams[it.index].t1.push(it.counter);
			sort();
			it.counter = 0;
		}
	}

	function sort() {
		it.teams[it.index].t1.forEach( function(element, index, array) {
			if (element > it.teams[it.index].max)
				it.teams[it.index].max = element;
		});
	}

	it.remove = function (index,t) {
		it.teams[it.index].t1.splice(t,1);

	}

	it.counting = function () {
		it.counter = Date.now() - startTime;
	}
});

app.controller('RaceController', function($scope,teamData) {
	var it = $scope;

	it.startTime = 0;
	it.numberLaps = 10;
	it.bestLap = 0;
	it.indexBest = 0;

	it.teams = [];
	it.$on('dataIsUpdated', function() {
		it.teams = teamData.getTeams();
	});

	it.startRace = function () {
		it.startTime = Date.now();
	}

	it.addLap = function(index){
		// check if race is started and team laps are less then maxium race
		if ( it.raceIs() && ( it.teams[index].laps < it.numberLaps )) {

			//chek best lap
			var laptime = Date.now() - it.teams[index].time - it.startTime;
			it.bestLap = (
				laptime <= it.bestLap || it.bestLap === 0 ?
				laptime :
				it.bestLap
			);
			it.indexBest = index;

			// UPDATE DATE AND LAPS OF ROBOT
			it.teams[index].time = Date.now() - it.startTime;
			it.teams[index].laps = it.teams[index].laps + 1;
			it.teams[index].finished = false;

			// CHECK IF ROBOT END THE RACE
			if (it.teams[index].laps === it.numberLaps) {
				it.teams[index].finished = true;
			}
		}
	};

	// check if the race is started
	it.raceIs = function () {
		return it.startTime > 0 ? true : false;
	}

});
