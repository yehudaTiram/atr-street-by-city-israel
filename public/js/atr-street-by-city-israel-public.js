/**
 * Adapted to Wordpress forms from https://codepen.io/tombigel/pen/LYbxPRa BY Tom B https://codepen.io/tombigel
 * Select a street by city in Israel
 * Cities data is from https://data.gov.il/dataset/citiesandsettelments
 * Streets data is from https://data.gov.il/dataset/321
 * API documentation https://docs.ckan.org/en/latest/maintaining/datastore.html#ckanext.datastore.logic.action.datastore_search
 *
 * @format
 */

const API_URL = "https://data.gov.il/api/3/action/datastore_search"; // Use const for constants
// Cities endpoint
const CITIES_RESOURCE_ID = "5c78e9fa-c2e2-4771-93ff-7f400a12f7ba";
// Streets endpoint
const STREETS_RESOURCE_ID = "a7296d1a-f8c9-4b70-96c2-6ebb4352f8e3";
// Field names
const CITY_NAME_KEY = "שם_ישוב";
const STREET_NAME_KEY = "שם_רחוב";
// dataset ids
const CITIES_DATA_ID = "cities-data";
const STREETS_DATA_ID = "streets-data";


// Setup input lists
// Add list attributes to both city-choice and streets-data fields
function setupInputLists(citiesInput, streetsInput) {
  if (!citiesInput ) {
    return;
  }
  citiesInput.setAttribute("list", "cities-data");
  if (!streetsInput) {
    return;
  }
  streetsInput.setAttribute("list", "streets-data");
}

/**
 * Add the datalist elements to the DOM
 */
function createListContainers(citiesInput, streetsInput) {
  // Create datalist elements for cities
  const citySelection = createElement("div", {
    id: "city-selection",
    class: "form-field",
  });
  const datalistElementCities = createElement(
    "datalist",
    { id: CITIES_DATA_ID },
    '<option value="">טוען רשימת ערים...</option>'
  );
  citySelection.appendChild(datalistElementCities);
  citiesInput.appendChild(citySelection);

  if (!streetsInput) {
    return;
  }
  // Create datalist elements for streets
  const streetSelection = createElement("div", {
    id: "street-selection",
    class: "form-field",
  });
  const datalistElementStreets = createElement(
    "datalist",
    { id: STREETS_DATA_ID },
    '<option value="">'
  );
  streetSelection.appendChild(datalistElementStreets);
  streetsInput.appendChild(streetSelection);
}

function populateCitiesPopulateStreetsOnChange(citiesInput) {
  /**
   * Populate cities.
   * There are about 1300 cities in Israel, and the API upper limit is 32000
   * so we can safely populate the list only once.
   */
  populateDataList(
    CITIES_DATA_ID,
    CITIES_RESOURCE_ID,
    CITY_NAME_KEY,
    undefined,
    32000
  );

  /**
   * Populate streets
   * Update the streets list on every city name change
   * (assuming there aren't more than 32,000 streets in any city)
   */
  citiesInput.addEventListener("change", (event) => {
    
    populateDataList(
      STREETS_DATA_ID,
      STREETS_RESOURCE_ID,
      STREET_NAME_KEY,
      { שם_ישוב: citiesInput.value },
      32000
    );
  });
}

/**
 * Create an element with attributes and content
 */
function createElement(tagName, attributes = {}, content = "") {
  const element = document.createElement(tagName);
  if (typeof attributes === "object") {
    for (const key in attributes) {
      element.setAttribute(key, attributes[key]);
    }
  }
  if (typeof content === "string") {
    element.textContent = content;
  }
  return element;
}

/**
 * Fetch data, parse, and populate Datalist
 */
async function populateDataList(id, resourceId, field_name, query = {}, limit) {
  
  

  const datalistElement = document.getElementById(id);
  if (!datalistElement) {
    console.log(
      "Datalist with id",
      id,
      "doesn't exist in the document, aborting"
    );
    return;
  }

  // Build URL with encoded query string
  const urlParams = new URLSearchParams();
  // Check if query object needs encoding (optional)
  if (typeof query !== "string") {
    query = JSON.stringify(query);
  }
  urlParams.append("q", query); // Add the encoded query object as "q" parameter because we need the param to be q={field_name:city_value}
  const queryString = urlParams.toString();
  const url = `${API_URL}?${queryString}&`;

  try {
    const response = await fetch(
      url + new URLSearchParams({ resource_id: resourceId, limit })
    );
    const data = await response.json();
    const html = await parseResponse(data?.result?.records, field_name);
    datalistElement.innerHTML = html;
  } catch (error) {
    
  }
}

/**
 * Parse records from data into 'option' elements,
 * use data from key 'field_name' as the option value
 */
function parseResponse(records = [], field_name) {
  const parsed =
    records
      .map((record) => `<option value="${record[field_name].trim()}">`)
      .join("\n") || "";
  
  return Promise.resolve(parsed);
}
