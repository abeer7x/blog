# واجهة برمجية (API) بسيطة لإنشاء وإدارة منشورات المدونة باستخدام Laravel.
## بناء واجهة برمجة تطبيقات (API) لإدارة المدونات مع استخدام جميع خصائص Laravel Form Request للتحقق من صحة البيانات وتجهيزها. سيتم التركيز بشكل خاص على استخدام جميع الـ methods في الـ Form Request وتوليد الـ Slug تلقائيًا إذا لم يتم إرساله.
| الطريقة | الرابط          | الوصف            |
| ------- | --------------- | ---------------- |
| GET     | /api/posts      | عرض كل المنشورات |
| GET     | /api/posts/{id} | عرض منشور محدد   |
| POST    | /api/posts      | إنشاء منشور جديد |
| PUT     | /api/posts/{id} | تعديل منشور      |
| DELETE  | /api/posts/{id} | حذف منشور        |
