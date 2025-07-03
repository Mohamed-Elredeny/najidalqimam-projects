-- Update equipment images
UPDATE equipment SET img = '/uploads/equipment/excavator.jpg' WHERE id = 1;
UPDATE equipment SET img = '/uploads/equipment/crane.jpg' WHERE id = 2;
UPDATE equipment SET img = '/uploads/equipment/bulldozer.jpg' WHERE id = 3;
UPDATE equipment SET img = '/uploads/equipment/truck.jpg' WHERE id = 4;

-- Update partners images
UPDATE partners SET img = '/uploads/partners/partner1.jpg' WHERE id = 1;
UPDATE partners SET img = '/uploads/partners/partner2.jpg' WHERE id = 2;
UPDATE partners SET img = '/uploads/partners/partner3.jpg' WHERE id = 3;
UPDATE partners SET img = '/uploads/partners/partner4.jpg' WHERE id = 4;
UPDATE partners SET img = '/uploads/partners/partner5.jpg' WHERE id = 5;

-- Add alt text for partners
UPDATE partners SET alt = 'Construction Partner 1' WHERE id = 1;
UPDATE partners SET alt = 'Engineering Partner 2' WHERE id = 2;
UPDATE partners SET alt = 'Infrastructure Partner 3' WHERE id = 3;
UPDATE partners SET alt = 'Development Partner 4' WHERE id = 4;
UPDATE partners SET alt = 'Architecture Partner 5' WHERE id = 5; 