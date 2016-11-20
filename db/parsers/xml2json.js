const Buffer = require('buffer').Buffer;
const Iconv = require('iconv').Iconv;
const parseString = require('xml2js').parseString;
const jsonfile = require('jsonfile');
const fs = require('fs');
const file = 'data.json';

let bytes = fs.readFileSync('30-EXXMLATU.xml');
let buf = new Buffer(bytes, 'binary');
let translated = new Iconv('CP1251', 'UTF8').convert(buf).toString();
let result_json  = {};
parseString(translated, {trim: true}, function (err, result) {
  result_json = result;
});

jsonfile.writeFile(file, result_json.DATA.RECORD, {spaces: 2}, function(err) {
  console.error(err)
});
