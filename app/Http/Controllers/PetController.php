<?php
namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{
    /**
     * ดึงรายการสัตว์เลี้ยงทั้งหมด พร้อมตัวกรองการค้นหา
     */
    public function index(Request $request)
    {
        $pets = Pet::query()
            // ค้นหาตามชนิดของสัตว์เลี้ยง (species)
            ->when($request->species, fn($q) => $q->where('species', 'LIKE', "%{$request->species}%"))
            // ค้นหาตามอายุ (age)
            ->when($request->age, fn($q) => $q->where('age', $request->age))
            // ค้นหาตามสถานะ (status)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            // ค้นหาตามช่วงราคา (price_min - price_max)
            ->when($request->price_min, fn($q) => $q->where('price', '>=', $request->price_min))
            ->when($request->price_max, fn($q) => $q->where('price', '<=', $request->price_max))
            ->get();

        return response()->json([
            'success' => true,
            'message' => $pets->isNotEmpty() ? 'Data found' : 'No data available',
            'count' => $pets->count(),
            'data' => $pets
        ]);
    }

    /**
     * สร้างข้อมูลสัตว์เลี้ยงใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่รับเข้ามา
        $validatedData = $request->validate([
            'name' => 'required',  // ชื่อสัตว์เลี้ยงต้องมีค่า
            'species' => 'required',  // ชนิดของสัตว์ต้องมีค่า
            'price' => 'required|numeric',  // ราคาต้องเป็นตัวเลขและห้ามว่าง
            'status' => 'required',  // สถานะของสัตว์ต้องมีค่า
        ]);

        // บันทึกข้อมูลลงฐานข้อมูลและส่งข้อมูลกลับ
        return response()->json([
            'success' => true,
            'message' => 'Pet created successfully',
            'data' => Pet::create($validatedData)
        ], 201); // HTTP 201 Created
    }

    /**
     * ดึงข้อมูลสัตว์เลี้ยงตัวเดียว
     */
    public function show(Pet $pet)
    {
        return response()->json([
            'success' => true,
            'message' => 'Pet data found',
            'data' => $pet
        ]);
    }

    /**
     * อัปเดตข้อมูลสัตว์เลี้ยง
     */
    public function update(Request $request, Pet $pet)
    {
        // ตรวจสอบข้อมูลก่อนอัปเดต
        $validatedData = $request->validate([
            'name' => 'required',
            'species' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);

        // อัปเดตข้อมูล
        $pet->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Pet updated successfully',
            'data' => $pet
        ]);
    }

    /**
     * ลบสัตว์เลี้ยงออกจากระบบ
     */
    public function destroy(Pet $pet)
    {
        $pet->delete(); // ลบข้อมูลออกจากฐานข้อมูล

        return response()->json([
            'success' => true,
            'message' => 'Pet deleted successfully'
        ]);
    }
}
