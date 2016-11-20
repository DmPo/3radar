'use strict';

const jsonfile = require('jsonfile');
const file = 'data.json';
const data = jsonfile.readFileSync(file);
const data_size = data.length;


/**
 *  OBL (OBL_NAME)
 */

function obl_parser() {

  let result = [];
  let result_json = [];

  for (let i = 0; i < data_size; i++) {
    if (result.indexOf(data[i]['OBL_NAME'][0]) == -1) {
      result.push(data[i]['OBL_NAME'][0]);
      result_json.push({id: result.length, name: data[i]['OBL_NAME'][0]})
    }
  }
  jsonfile.writeFileSync('obl_db.json', result_json, {spaces: 2});
  jsonfile.writeFileSync('obl.json', result, {spaces: 2});
  return {array: result, json: result_json}
}
console.log('obl started_at: ', new Date());
const obls = obl_parser();
console.log('obl ended_at: ', new Date());

/**
 * Regions (REGION_NAME)
 */
console.log('Regions started_at: ', new Date());
function region_parser() {
  let result = [];
  let result_json = [];

  for (let i = 0; i < data_size; i++) {
    let field = data[i]['REGION_NAME'][0];
    if (result.indexOf(field) == -1 && field.length && field.search('р.Райони') == -1) {
      result.push(field);
      result_json.push({
        id: result.length,
        name: data[i]['REGION_NAME'][0],
        obl_id: obls.array.indexOf(data[i]['OBL_NAME'][0]) + 1
      })
    }
  }
  jsonfile.writeFileSync('region_db.json', result_json, {spaces: 2});
  jsonfile.writeFileSync('region.json', result, {spaces: 2});
  return {array: result, json: result_json}
}
const regions = region_parser();
console.log('Regions ended_at: ', new Date());


/**
 * Cities (CITY_NAME)
 *  | with CITY_REGION_NAME
 *  | | if (region_id = null && city_id = null)    - >   OBL center
 *  | | if (region_id = null && city_id != null)   - >   city without region
 */

console.log('Cities started_at: ', new Date());

function cities_parser() {
  let result = [];
  let result_json = [];

  console.log('Cities |first| started_at: ', new Date());
  for (let i = 0; i < data_size; i++) {
    let field = data[i]['CITY_NAME'][0];
    let duplicate = {
      name: field,
      obl_id: data[i]['OBL_NAME'][0],
      region_id: data[i]['REGION_NAME'][0].length ? data[i]['REGION_NAME'][0] : null,
      city_id: null,
    };
    if (field.length > 3 && field != 'Не визначений Н.П.' && result.indexOf(JSON.stringify(duplicate)) == -1) {
      result.push(JSON.stringify(duplicate));
      result_json.push({
        id: result.length,
        name: field,
        region_id: data[i]['REGION_NAME'][0].length ? regions.array.indexOf(data[i]['REGION_NAME'][0]) + 1 : null,
        city_id: null,
      });
    }

  }
  console.log('Cities |second| started_at: ', new Date());
  for (let i = 0; i < data_size; i++) {
    let field = data[i]['CITY_REGION_NAME'][0];
    let _city = {
      name: data[i]['CITY_NAME'][0],
      obl_id: data[i]['OBL_NAME'][0],
      region_id: data[i]['REGION_NAME'][0].length ? data[i]['REGION_NAME'][0] : null,
      city_id: null,
    };

    let duplicate = {
      name: field,
      obl_id: data[i]['OBL_NAME'][0],
      region_id: null,
      city_id: result.indexOf(JSON.stringify(_city)) + 1 || null,
    };

    let city_id = result.indexOf(JSON.stringify(_city)) + 1;
    if (field.length > 2 && result.indexOf(JSON.stringify(duplicate)) == -1 && city_id) {
      result.push(JSON.stringify(duplicate));
      result_json.push({
        id: result.length,
        name: field,
        region_id: null,
        city_id: city_id || null
      })
    }
  }

  jsonfile.writeFileSync('cities_db.json', result_json, {spaces: 2});
  jsonfile.writeFileSync('cities.json', result, {spaces: 2});
  return {array: result, json: result_json}
}
const cities = cities_parser();
console.log('Cities ended_at: ', new Date());

/**
 * TOV (TOV_NAME)
 */
console.log('TOV started_at: ', new Date());

function tov_parser() {
  let result = [];
  let result_json = [];

  for (let i = 0; i < data_size; i++) {

    let field = data[i]['TOV_NAME'][0];
    let duplicate = {
      name: field,
      obl: data[i]['OBL_NAME'][0],
      city: data[i]['CITY_NAME'][0]
    };
    if (result.indexOf(JSON.stringify(duplicate)) == -1 && field.length) {
      result.push(JSON.stringify(duplicate));
      result_json.push({
        id: result.length,
        name: field,
        region_id: data[i]['REGION_NAME'][0].length ? regions.array.indexOf(data[i]['REGION_NAME'][0]) + 1 : null,
      })
    }
  }
  jsonfile.writeFileSync('tov_db.json', result_json, {spaces: 2});
  jsonfile.writeFileSync('tov.json', result, {spaces: 2});
  return {array: result, json: result_json}
}
tov_parser();
console.log('TOV ended_at: ', new Date());


/**
 * Streets (STREET_NAME)
 */
console.log('STREET_NAME started_at: ', new Date());

function streets_parser() {
  let result = [];
  let result_json = [];
  for (let i = 0; i < data_size; i++) {
    let field = data[i]['STREET_NAME'][0];
    let duplicate = {
      name: field,
      obl: data[i]['OBL_NAME'][0],
      city: data[i]['CITY_NAME'][0],
      tov: data[i]['TOV_NAME'][0]
    };
    let _city = {
      name: data[i]['CITY_NAME'][0],
      obl_id: data[i]['OBL_NAME'][0],
      region_id: data[i]['REGION_NAME'][0].length ? data[i]['REGION_NAME'][0] : null,
      city_id: result.indexOf(JSON.stringify(this)) + 1 || null
    };

    if (field.length > 2 && result.indexOf(JSON.stringify(duplicate)) == -1) {
      result.push(JSON.stringify(duplicate));
      result_json.push({
        id: result.length,
        name: field,
        city_id: cities.array.indexOf(JSON.stringify(_city)) + 1,
      })
    }
  }
  jsonfile.writeFileSync('streets_db.json', result_json, {spaces: 2});
  jsonfile.writeFileSync('streets.json', result, {spaces: 2});
  return {array: result, json: result_json}
}
const streets = streets_parser();

console.log('STREET_NAME ended_at: ', new Date());
