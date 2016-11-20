'use strict';

const jsonfile = require('jsonfile');
const file = 'data.json';
console.info('start read data file');
const data = jsonfile.readFileSync(file);
const data_size = data.length;
console.info('end read data file');
for (let i = 0; i < data_size; i++) {
  let field = data[i]['CITY_NAME'][0];
  if (field.search('Не визначений Н.П.') >= 0)
    console.log(data[i]);
}