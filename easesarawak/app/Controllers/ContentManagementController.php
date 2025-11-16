<?php
namespace App\Controllers;
use App\Models\ContentManagementModel;

class ContentManagementController extends BaseController
{
    public function index()
    {
        // You can load any data you need from the model here
        $model = new ContentManagementModel();
        $contentData = $model->findAll();

        return view('/admin/content_management', ['contentData' => $contentData]);
    }

    public function store()
    {
        $model = new \App\Models\ContentManagementModel();

        $type    = $this->request->getPost('type');
        $title   = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        $data = [
            'type'    => $type,
            'title'   => $title,
            'content' => $content,
            'is_active' => 1 // Make new content active by default
        ];

        // Handle image upload
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads', $newName);
            $data['image'] = $newName;
        }

        // Set all other content of this type to inactive
        $model->where('type', $type)->set(['is_active' => 0])->update();

        // Insert new content as active
        $model->insert($data);

        return redirect()->to('/admin/content_management')->with('success', 'Content added and set as active!');
    }

    public function set_active($id)
    {
        $model = new \App\Models\ContentManagementModel();
        $row = $model->find($id);
        if ($row) {
            // Set all of this type to inactive
            $model->where('type', $row['type'])->set(['is_active' => 0])->update();
            // Set this one to active
            $model->update($id, ['is_active' => 1]);
        }
        return redirect()->to('/admin/content_management')->with('success', 'Content activated!');
    }

    public function set_inactive($id)
    {
        $model = new \App\Models\ContentManagementModel();
        $model->update($id, ['is_active' => 0]);
        return redirect()->to('/admin/content_management')->with('success', 'Content set as inactive!');
    }

    // Show main page with content under navbar
    public function main()
    {
        $model = new \App\Models\ContentManagementModel();
        $mainContent = $model->where('type', 'main')->where('is_active', 1)->orderBy('created_at', 'DESC')->first();
        return view('home', ['mainContent' => $mainContent]);
    }

    // Show booking page with content under navbar
    public function booking()
    {
        $model = new \App\Models\ContentManagementModel();
        $bookingContent = $model->where('type', 'booking')->where('is_active', 1)->first();
        return view('booking', ['bookingContent' => $bookingContent]);
    }

    public function delete($id)
    {
        $model = new \App\Models\ContentManagementModel();
        $model->delete($id);
        return redirect()->to('/admin/content_management')->with('success', 'Content deleted!');
    }
}