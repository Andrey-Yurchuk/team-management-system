-- Запрос для получения общего количества проектов
SELECT COUNT(*) AS total_projects
FROM project;

-- Запрос для получения общего количества разработчиков
SELECT COUNT(*) AS total_developers
FROM developer;

-- Запрос для вычисления среднего возраста сотрудников
SELECT ROUND(AVG(DATEDIFF(CURDATE(), birth_date) / 365), 1) AS average_age
FROM developer
WHERE birth_date IS NOT NULL;

-- Запрос для подсчета количества сотрудников по проектам
SELECT p.name AS project_name, COUNT(d.id) AS total_developers
FROM project p
LEFT JOIN developers_projects dp ON dp.project_id = p.id
LEFT JOIN developer d ON d.id = dp.developer_id
GROUP BY p.id;

-- Запрос для получения списка всех проектов с их заказчиками
SELECT name AS project_name, client AS project_client
FROM project;