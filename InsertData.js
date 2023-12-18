const db = require('./db');

const newData = { name: 'John Doe', age: 25, email: 'john@example.com' };

db.query('INSERT INTO test SET ?', newData, (err, results) => {
  if (err) {
    console.error('Error inserting data:', err);
    return;
  }
  console.log(`Inserted ${results.affectedRows} row into the table`);
});

db.end((err) => {
  if (err) {
    console.error('Error closing MySQL connection:', err);
    return;
  }
  console.log('MySQL connection closed');
});
