<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class DocumentController extends Controller
{

    
    public function create()
    {
        return view('DocToHTML');
    }

    
    public function docFileHandler(Request $request){
        
        try {
            $this->validate($request, [
                'doc_file' => 'required|file|mimes:doc,docx',
            ]);
    
            $docFile = $request->file('doc_file');
            $fullTempFilePath = $docFile->path();
    
            // Log the file path for debugging
            Log::info("Uploaded File Path: $fullTempFilePath");
    
            // Check if the file exists
            if (!file_exists($fullTempFilePath)) {
                Log::error("File not found: $fullTempFilePath");
                return response()->json(['error' => 'File not found.'], 404);
            }
    
            // Load the Word document
            $phpWord = IOFactory::load($fullTempFilePath);
    
            // Save the Word document as HTML
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
            ob_start();
            $htmlWriter->save('php://output', $phpWord, false);  // Save HTML content to output buffer
            $htmlContent = ob_get_clean();
    
            // Use the original name of the uploaded document as the name for the HTML file
            $htmlFileName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME) . '.html';

            $data=array(
            'file_name'=> $htmlFileName,
            'content'=> $htmlContent
            );

            // Download the HTML file
            return $data;
        } catch (\Exception $e) {
            Log::error("Error during conversion: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function convertDocToHtml(Request $request)
    {
        try {
    
            // Use the original name of the uploaded document as the name for the HTML file
            $data = $this->docFileHandler($request);
            
            $htmlFileName= $data['file_name'];
            $htmlContent= $data['content'];
    
            // Save the HTML content to a file
            Storage::put($htmlFileName, $htmlContent);
    
            // Download the HTML file
            
        $link = storage_path('app/' . $htmlFileName);
        return response()->download($link, $htmlFileName);
        } catch (\Exception $e) {
            Log::error("Error during conversion: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function viewDocToHtml(Request $request)
    {
        try {
            
            // Use the original name of the uploaded document as the name for the HTML file
            $data = $this->docFileHandler($request);
            
            $htmlFilePath= $data['file_name'];
            $htmlContent= $data['content'];

            Storage::put($htmlFilePath, $htmlContent);

            // Return the HTML content as a response
            

        // Download the HTML file using the symbolic link URL
        return response()->download( $htmlFilePath, [
            'Content-Disposition' => 'inline; filename="' . $htmlFilePath . '"',
            ]);
        } catch (\Exception $e) {
            Log::error("Error during conversion: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

