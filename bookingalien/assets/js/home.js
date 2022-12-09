if(window.location.pathname === "/") {
    let selectCountry = document.querySelector("#country-select");
    let selectCity = document.querySelector("#city-select");
    let selectHotel = document.querySelector("#hotel-select");
    let button = document.querySelector("#goToHotelPage");

    selectCountry.addEventListener('change', () => {
       if(selectCountry.value === null){
           selectCity.disabled = true;
       }else{
           selectCity.disabled = false;
           let xhr = new XMLHttpRequest();
           xhr.open("GET", "/country/"+selectCountry.value+"/cities");
           xhr.onreadystatechange = () => {
               if (xhr.readyState !== 4) return;
               selectCity.innerHTML = "<option value=\"\" disabled selected>-- Ville --</option>";
               let data = JSON.parse(xhr.response);
               console.log(data);
               data.forEach(row => {
                   let opt = document.createElement('option');
                   opt.value = row.id;
                   opt.innerHTML = row.cityName;
                   selectCity.appendChild(opt);
               })
           };
           xhr.send();
       }
    });

    selectCity.addEventListener('change', () => {
        if(selectCountry.value === null){
            selectHotel.disabled = true;
        }else{
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "/city/"+selectCity.value+"/hotels");
            xhr.onreadystatechange = () => {
                if (xhr.readyState !== 4) return;
                selectHotel.innerHTML = "<option value=\"\" disabled selected>-- Hôtel --</option>";
                let data = JSON.parse(xhr.response);
                console.log(data);
                data.forEach(row => {
                    let opt = document.createElement('option');
                    opt.value = row.id;
                    opt.innerHTML = row.hotelName;
                    selectHotel.appendChild(opt);
                })
            };
            xhr.send();
            selectHotel.disabled = false;
        }
    });

    selectHotel.addEventListener("change", () => {
        button.setAttribute("data-url", "/hotel/" + selectHotel.value);
    });

    button.addEventListener("click", () => {
       window.location.replace(button.getAttribute("data-url"));
    });
}
