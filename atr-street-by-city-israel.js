/**
 * Adapted to Contact form 7 from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel
 * Select a street by city in Israel
 * Cities data is from https://data.gov.il/dataset/citiesandsettelments
 * Streets data is from https://data.gov.il/dataset/321
 * API documentation https://docs.ckan.org/en/latest/maintaining/datastore.html#ckanext.datastore.logic.action.datastore_search
 */
 
const api_url = "https://data.gov.il/api/3/action/datastore_search";
// Cities endpoint
const cities_resource_id = "5c78e9fa-c2e2-4771-93ff-7f400a12f7ba";
// Streets endpoint
const streets_resource_id = "a7296d1a-f8c9-4b70-96c2-6ebb4352f8e3";
// Field names
const city_name_key = "שם_ישוב";
const street_name_key = "שם_רחוב";
// dataset ids
const cities_data_id = "cities-data";
const streets_data_id = "streets-data";
window.onload = (event) => {
	  
// REST API URL

// input elements
const cities_input = document.getElementById("city-choice");
const streets_input = document.getElementById("street-choice");

// Add list attributes to both city-choice and streets-data  
cities_input.setAttribute("list", "cities-data");
streets_input.setAttribute("list", "streets-data");
	
const citySelection = createElement("div", {
  id: "city-selection",
  class: "form-field",
});

const datalistElementCities = createElement("datalist", {
  id: "cities-data",
}, '<option value="">טוען רשימת ערים...</option>');

citySelection.appendChild(datalistElementCities);
cities_input.appendChild(citySelection);


const streetSelection = createElement("div", {
  id: "street-selection",
  class: "form-field",
});

const datalistElementStreets = createElement("datalist", {
  id: "streets-data",
}, '<option value="">');

streetSelection.appendChild(datalistElementStreets);
cities_input.appendChild(streetSelection);


/**
 * Get data from gov data API
 * Uses Axios just because it was easy
 */
function getData(resource_id, q = "", limit = "100") {
  return $.ajax({
    url: api_url,
    type: 'GET',
    dataType: 'json', // Specify data type (optional)
    data: {
          resource_id: resource_id,
          limit: limit, 
          q: query
    }
  })
  .then(response => {
    console.log("Success! Data:", response);
    return response; // Return the response data for further processing
  })
  .catch(error => {
    console.error("Error fetching data:", error);
  });
}
/**
 * Populate cities.
 * There are about 1300 cities in Israel, and the API upper limit is 32000
 * so we can safely populate the list only once.
 */
populateDataList(
cities_data_id,
cities_resource_id,
city_name_key,
undefined,
32000);


/**
 * Populate streets
 * Update the streets list on every city name change
 * (assuming there aren't more than 32,000 streets in any city)
 */
cities_input.addEventListener("change", event => {
	console.log("cities_input changed");
  populateDataList(
  streets_data_id,
  streets_resource_id,
  street_name_key,
  {
    שם_ישוב: cities_input.value },

  32000);

});
};

function createElement(tagName, attributes = {}, content = ""){
  // Create the element
  const element = document.createElement(tagName);

  // Set attributes (if object is provided)
  if (typeof attributes === "object") {
    for (const key in attributes) {
      element.setAttribute(key, attributes[key]);
    }
  }

  // Set content (if string is provided)
  if (typeof content === "string") {
    element.textContent = content; // Use textContent for text content
  }

  // Return the created element
  return element;
}


/**
 * Parse records from data into 'option' elements,
 * use data from key 'field_name' as the option value
 */
function parseResponse(records = [], field_name){
  const parsed =
  records.
  map(record => `<option value="${record[field_name].trim()}">`).
  join("\n") || "";
  console.log("parsed", field_name, parsed, records);
  return Promise.resolve(parsed);
}

/**
 * Fetch data, parse, and populate Datalist
 */
async function populateDataList(id, resource_id, field_name, query = {}, limit) {
  console.log("resource_id 136: ", resource_id);
  console.log("query 152: ", query);

  const datalist_element = document.getElementById(id);
  if (!datalist_element) {
    console.log("Datalist with id", id, "doesn't exist in the document, aborting");
    return;
  }

  // Build URL with encoded query string
  const urlParams = new URLSearchParams();

  // Check if query object needs encoding (optional)
  if (typeof query !== 'string') {
    query = JSON.stringify(query); // Encode query object as JSON string if not already a string
  }
  urlParams.append("q", query);  // Add the encoded query object as "q" parameter because we need the param to be q={field_name:city_value}

  const queryString = urlParams.toString(); // Get encoded string
  const url = api_url + "?" + queryString + "&";

  let response = await fetch(url + new URLSearchParams({
      resource_id: resource_id,
      limit: limit  // Only send resource_id and limit in data object
})
).then(async response => {
	console.log("response ", response);
		const movies = await response.json();
		return parseResponse(movies?.result?.records, field_name)
	  })
	  .then(html => datalist_element.innerHTML = html)
	  .catch(error => {
    console.log("Couldn't get list for", id, "query:", query, error);
  });

	/* A jQury implementation of the same */
  // jQuery.ajax({
    // url: url,  
    // type: 'GET',
    // dataType: 'json',
    // data: {
      // resource_id: resource_id,
      // limit: limit  // Only send resource_id and limit in data object
    // },
    // success: function(response) {
      // console.log("response ", response);
      // return parseResponse(response?.result?.records, field_name)
        // .then(html => datalist_element.innerHTML = html);
    // },
    // error: function(jqXHR, textStatus, errorThrown) {
      // console.error("Error fetching data:", textStatus, errorThrown);
    // }
  // });
}




