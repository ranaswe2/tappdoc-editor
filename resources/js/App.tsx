import React, { useState } from 'react';
import './App.css';
import {DocumentEditorContainerComponent,Toolbar,Inject} from '@syncfusion/ej2-react-documenteditor';


function App() {
  let editorObj: DocumentEditorContainerComponent | null;
  const [filename, setFilename] = useState('Sample');

    const onSaveAsDOCX=()=>{
        const fileNameToSave = filename || 'no name';
        editorObj?.documentEditor.save(fileNameToSave,'Docx');
    }

  const onSaveAsHTML=()=>{
    const fileNameToSave = filename || 'no name';
    //editorObj?.documentEditor.save('sample','Docx');

      let url: string = editorObj?.documentEditor.serviceUrl + 'ExportSFDT';
      let http: XMLHttpRequest = new XMLHttpRequest();
      http.open('POST', url);
      http.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
      http.responseType = 'blob'; // Setting response type to blob
      let sfdt: any = {
          content: editorObj?.documentEditor.serialize(),
          fileName: fileNameToSave+'.html',
      };
      http.onreadystatechange = function() {
          if (http.readyState === XMLHttpRequest.DONE && http.status === 200) {
              // Create a blob object from the response
              const blob = new Blob([http.response], { type: 'application/octet-stream' });
              // Create a temporary anchor element
              const a = document.createElement('a');
              // Create object URL from the blob
              const url = window.URL.createObjectURL(blob);
              // Set anchor element attributes
              a.href = url;
              a.download = fileNameToSave+'.html'; // Set the filename
              // Simulate a click on the anchor element to prompt download
              a.click();
              // Clean up resources
              window.URL.revokeObjectURL(url);
          }
      };
      http.send(JSON.stringify(sfdt));

  }

  return (
      
<div className="App">
<div style={{ display: 'flex', justifyContent: 'space-between', background: 'lightblue' }}>
  <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: 5, background: '#088F8F'}}>
    <input
      type="text"
      placeholder="Enter filename"
      value={filename}
      onChange={(e) => setFilename(e.target.value)} // Update the filename state
      style={{ marginRight: 100, marginLeft: 8, marginBottom: 10 }}
    />
    <button onClick={onSaveAsDOCX} style={{ marginRight: 10, marginBottom: 5  }}>
      Save As Docx
    </button>
    
    <button onClick={onSaveAsHTML} style={{ marginRight: 10, marginBottom: 5  }}>
      Save As HTML
    </button>
  </div>
    

  </div>

  <DocumentEditorContainerComponent ref={(ins => editorObj = ins)} height='590'
                                            serviceUrl="http://localhost:9090/api/wordeditor/" enableToolbar={true}>
              <Inject services={[Toolbar]}></Inject>
          </DocumentEditorContainerComponent>
</div>
  );
}

export default App;






