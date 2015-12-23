###Query examples

1. List of all equipment:
select name as brand, equipment_type as equipment, model from equipment join brand on equipment.brand_id=brand.id join `type` on equipment.type_id=type.id;

2. List of employees and correspondent equipment

select first_name, last_name, `name` as brand, equipment_type as equipment, quantity from employee 
join employee_equipment on employee_equipment.employee_id=employee.id 
join equipment on employee_equipment.equipment_id=equipment.id
join brand on equipment.brand_id=brand.id 
join `type` on equipment.type_id=type.id;


3. Who has LCD MNT?

SELECT first_name, last_name,  `name` AS brand, equipment_type AS equipment, quantity
    -> FROM employee
    -> JOIN employee_equipment ON employee_equipment.employee_id = employee.id
    -> JOIN equipment ON employee_equipment.equipment_id = equipment.id
    -> JOIN brand ON equipment.brand_id = brand.id
    -> JOIN  `type` ON equipment.type_id = type.id
    -> WHERE type.id =2; // 2=LCD monitor
