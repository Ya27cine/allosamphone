
const clock_day 	 = document.querySelector("#day")
const clock_hours	 = document.querySelector("#hours")
const clock_mins	 = document.querySelector("#mins")
const clock_secs 	 = document.querySelector("#secs")


	 let now = new Date();
     clock_hours.innerHTML = now.getHours();
     clock_mins.innerHTML = now.getMinutes();
     clock_secs.innerHTML = now.getSeconds();

const myOclock = () => {
	 let now = new Date();
     clock_hours.innerHTML = now.getHours();
     clock_mins.innerHTML = now.getMinutes();
     clock_secs.innerHTML = now.getSeconds();
}

setInterval(myOclock, 1000)