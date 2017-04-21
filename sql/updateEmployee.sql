UPDATE final_employees
SET fullname = :fullname, address = :address, city = :city, stateOfResidence = :stateOfResidence, zipCode = :zipCode, payGrade = :payGrade, jobPosition = :jobPosition
WHERE employeeID = :employeeID
