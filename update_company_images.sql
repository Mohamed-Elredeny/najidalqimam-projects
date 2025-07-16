-- Update services_intro images with actual project images
UPDATE services_intro SET 
    img1 = '/uploads/projects/facilities.jpg',
    img2 = '/uploads/projects/public.jpg',
    img3 = '/uploads/projects/renovation.jpg'
WHERE id = 1; 