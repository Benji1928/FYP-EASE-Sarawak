module.exports = {
  development: {
    client: 'mysql2',
    connection: {
      host: '127.0.0.1',
      port: 3306,
      user: 'root',
      password: '',        
      database: 'easesarawak' 
    },
    migrations: { directory: './migrations', tableName: 'knex_migrations' },
    seeds: { directory: './seeds' }
  }
};