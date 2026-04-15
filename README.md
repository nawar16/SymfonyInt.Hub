A simple modular monolith designed for enterprise-level organization without the overhead of microservices. The modules are strictly decoupled, making it easy to extract them into independent services as the system scales.

To keep the core clean, I use dedicated integration modules to fetch external data and normalize it into DTOs. 
Business logic stays independent of the framework, while Doctrine ORM handles the persistence layer.

