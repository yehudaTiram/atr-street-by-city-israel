/**
 * Adapted to Contact form 7 from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel
 * Select a street by city in Israel
 * Cities data is from https://data.gov.il/dataset/citiesandsettelments
 * Streets data is from https://data.gov.il/dataset/321
 * API documentation https://docs.ckan.org/en/latest/maintaining/datastore.html#ckanext.datastore.logic.action.datastore_search
 */
 /*
 add to functions.php or toplugin:
 add_action( 'wp_footer', 'load_axios' );
function load_axios() {
	?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js'></script>
<?php
}
 */
window.onload = (event) => {	
		  
// REST API URL
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
// input elements
const cities_input = document.getElementById("city-choice");
const streets_input = document.getElementById("street-choice");

// Add list attributes to both city-choice and streets-data  
cities_input.setAttribute("list", "cities-data");
streets_input.setAttribute("list", "streets-data");
	
function createElement(tagName, attributes = {}, content = "") {
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
const getData = (resource_id, q = "", limit = "100") => {
  return axios.get(api_url, {
    params: { resource_id, q, limit },
    responseType: "json" });

};

const getData1 = async (resource_id, q = "", limit = "100") => {
jQuery.ajax({
  url: api_url,
  type: 'GET',
  dataType: 'json', // Specify expected data type (optional)
  data: {
    resource_id: resource_id,
    q: q,
    limit: limit
  },
  success: function(response) {
	  return response;
    console.log("Success! Data:", response);
    // Process the response data here
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.error("Error fetching data:", textStatus, errorThrown);
    // Handle errors here
  }
});
};

/**
 * Parse records from data into 'option' elements,
 * use data from key 'field_name' as the option value
 */
const parseResponse = (records = [], field_name) => {
  const parsed =
  records.
  map(record => `<option value="${record[field_name].trim()}">`).
  join("\n") || "";
  //console.log("parsed", field_name, parsed);
  return Promise.resolve(parsed);
};

/**
 * Fetch data, parse, and populate Datalist
 */
const populateDataList = (id, resource_id, field_name, query, limit) => {
	console.log("resource_id 136: ", resource_id);
  const datalist_element = document.getElementById(id);
  if (!datalist_element) {
    console.log(
    "Datalist with id",
    id,
    "doesn't exist in the document, aborting");

    return;
  }
  getData(resource_id, query, limit).
  then(response => {var _response$data, _response$data$result;return (
      parseResponse(response === null || response === void 0 ? void 0 : (_response$data = response.data) === null || _response$data === void 0 ? void 0 : (_response$data$result = _response$data.result) === null || _response$data$result === void 0 ? void 0 : _response$data$result.records, field_name));}).

  then(html => datalist_element.innerHTML = html).
  catch(error => {
    console.log("Couldn't get list for", id, "query:", query, error);
  });
};

// ---- APP ----

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